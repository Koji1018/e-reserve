<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon; // 時間操作用

use App\Reservation;
use App\Category;
use App\Equipment;

class ReservationsController extends Controller
{
    // トップページ画面かつユーザ予約状況画面の表示用
    public function index_user()
    {
        $data = [];
		if (\Auth::check()) { // 認証済みの場合				
			$user = \Auth::user(); // 認証済みユーザを取得
			$datetime = Carbon::now('Asia/Tokyo'); // 現在の日時取得
			$today = Carbon::yesterday('Asia/Tokyo'); // 現在の日時取得
 			$reservations = $user->reservations()->where('status',1)
 			    ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
 			    ->orderBy('lending_start', 'asc')->paginate(10);
			$data = [
				'user' => $user,
				'reservations' => $reservations,
				'datetime' => $datetime,
				'today' => $today,
			];
			return view('reservations.index_user', $data); // lendings/userビューでそれらを表示
		} else return view('auth.login');
    }

    // 全体貸出状況画面の表示用
    public function index_all()
    {
        $datetime = Carbon::now('Asia/Tokyo');
        $aftertime = Carbon::now('Asia/Tokyo')->addHours(1)->format('H:i'); // 現在の1時間後

        // カテゴリー名
        $categories = Category::orderBy('name', 'asc')->paginate(10);
        
        // カテゴリーの備品類
        foreach($categories as $category){
            $equipments = $category->equipments->where('status',0);
            $count = 0; // 初期化
            $reserved_list = [];
            foreach($equipments as $equipment){
                $reservations_count = Reservation::orderBy('lending_start', 'asc')
                    ->where('equipment_id', $equipment->id)
                    ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
                    ->whereTime('lending_start','>=',$datetime->format('H:i'))->whereTime('lending_start','<',$aftertime)
                    ->get();
                if(count($reservations_count) == 0){
                    $reservations_count = Reservation::orderBy('lending_start', 'asc')
                        ->where('equipment_id', $equipment->id)
                        ->where('lending_end','like', $datetime->format('Y-m-d'). '%')
                        ->whereTime('lending_end','>=',$datetime->format('H:i'))->whereTime('lending_end','<',$aftertime)
                        ->get();
                    if(count($reservations_count) == 0){
                        $reservations_count = Reservation::orderBy('lending_start', 'asc')
                            ->where('equipment_id', $equipment->id)
                            ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
                            ->whereTime('lending_start','<=',$datetime->format('H:i'))->whereTime('lending_end','>',$aftertime)
                            ->get();
                        if(count($reservations_count) != 0) $reserved_list[] = $count;
                    }else $reserved_list[] = $count; 
                }else $reserved_list[] = $count;
                $count++;
            }
            if($reserved_list == null){
                $reserve_ok[] = count($equipments);
                $reserve_ng[] = 0;
            } 
            else{
                $reserve_ok[] = count($equipments) - count($reserved_list);
                $reserve_ng[] = count($reserved_list);
            }
            $total[] = count($equipments);
            
        }

        return view('reservations.index_all', [
            'categories' => $categories,
            'reserve_oks' => $reserve_ok,
            'reserve_ngs' => $reserve_ng,
            'totals' => $total,
            'datetime' => $datetime,
            'aftertime' => $aftertime,
        ]);
    }

    // カテゴリー別貸出状況画面の表示用
    public function index_category()
    {
        $datetime = Carbon::now('Asia/Tokyo');
        
        // カテゴリー一覧をnameの昇順で、「キー:id、値:name」で取得(セレクトボックス用)
		$category = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
		
		// カテゴリーに属する備品一覧
		$query = Equipment::orderBy('name', 'asc')->where('status',0)->where('category_id', 1);
		$equipments = $query->paginate(20);
		
		// 時間表示
		$month = ['09','10','11','12','13','14','15','16','17','18','19','20','21','22']; // 時
		$minute = ['00','30']; // 分
		
		for($i = 0; $i < count($month); $i++){
		    $time[] = $month[$i]. ':'. $minute[0]; 
		    $time[] = $month[$i]. ':'. $minute[1];
		}
		
		// 各備品の予約時間を取得
		$count = 0;
		foreach($equipments as $equipment){
		    $reserved_list[$count] = [];
		    for($i = 0; $i < count($time)-1; $i++){
    		    $reserved_check = Reservation::orderBy('lending_start', 'asc')
                    ->where('equipment_id', $equipment->id)
                    ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
                    ->whereTime('lending_start','>=',$time[$i])->whereTime('lending_start','<',$time[$i+1])
                    ->get();
                if(count($reserved_check) == 0){
                    $reserved_check = Reservation::orderBy('lending_start', 'asc')
                        ->where('equipment_id', $equipment->id)
                        ->where('lending_end','like', $datetime->format('Y-m-d'). '%')
                        ->whereTime('lending_end','>=',$time[$i])->whereTime('lending_end','<',$time[$i+1])
                        ->get();
                    if(count($reserved_check) == 0){
                        $reserved_check = Reservation::orderBy('lending_start', 'asc')
                        ->where('equipment_id', $equipment->id)
                        ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
                        ->whereTime('lending_start','<=',$time[$i])->whereTime('lending_end','>',$time[$i+1])
                        ->get();
                    }
                }
                if(count($reserved_check) != 0) $reserved_list[$count][] = 1; 
                else $reserved_list[$count][] = 0;
		    }
            $count++;
		}

		return view('reservations.index_category', [
            'category' => $category,
            'equipments' => $equipments,
            'time' => $time,
            'id'=> 1,
            'datetime' => $datetime,
            'reserved_list' => $reserved_list,
        ]);
    }

    // 貸出予約画面の表示用
    public function create()
    {
        $user = \Auth::user(); // 認証済みユーザを取得
        
        // カテゴリー一覧をnameの昇順で、「キー:id、値:name」で取得(セレクトボックス用)
		$category = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
		
		$reservation = "";
		
		$empty_check = 0;
		
		// ユーザの予約(check状態)を貸出開始日時の昇順で取得
		$reservations_confirm = $user->reservations()->where('status',0)->orderBy('lending_start', 'asc')->paginate(10);
		
        // 貸出予約ビューでそれを表示
        return view('reservations.create', [
            'category' => $category,
            'reservation' => $reservation,
            'empty_check' => $empty_check,
            'reservations_confirm' => $reservations_confirm,
        ]);
    }
    
    // 貸出予約処理用(空き確認) 
    public function reserve_check(Request $request)
    {
        // バリデーション
        $request->validate([
            'reserve_date' => 'required|after:"yesterday"',
            'reserve_time_start' => 'required',
            'reserve_time_end' => 'required|after:reserve_time_start',
            'category_id' => 'required',
            'number' => 'required',
        ]);
        
        // 次画面に入力情報を保持するため
        $reservation = $request;
        
        $user = \Auth::user(); // 認証済みユーザを取得

        // カテゴリー一覧をnameの昇順で、「キー:id、値:name」で取得(セレクトボックス用)
		$category = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        
        $equipments = Category::findOrFail($request->category_id)->equipments->where('status',0); // カテゴリーに属する備品一覧

        $count = 0;  // delete_list用(配列の何番目かを確認)
        $delete_list[] = "";
            
        // 貸出期間内に予約のない備品一覧を取得する
        foreach($equipments as $equipment){
            // 貸出期間内の予約一覧を取得する
            // 予約開始時間に被りがないか確認
            $reservations_count = Reservation::orderBy('lending_start', 'asc')
                ->where('equipment_id', $equipment->id)
                ->where('lending_start','like', $request->reserve_date .'%')
                ->whereTime('lending_start','>=',$request->reserve_time_start)->whereTime('lending_start','<',$request->reserve_time_end)
                ->get();
            if(count($reservations_count) == 0){
                $reservations_count = Reservation::orderBy('lending_start', 'asc')
                    ->where('equipment_id', $equipment->id)
                    ->where('lending_end','like', $request->reserve_date .'%')
                    ->whereTime('lending_end','>=',$request->reserve_time_start)->whereTime('lending_end','<',$request->reserve_time_end)
                    ->get();
                if(count($reservations_count) == 0){
                    $reservations_count = Reservation::orderBy('lending_start', 'asc')
                        ->where('equipment_id', $equipment->id)
                        ->where('lending_start','like', $request->reserve_date .'%')
                        ->whereTime('lending_start','<=',$request->reserve_time_start)->whereTime('lending_end','>',$request->reserve_time_end)
                        ->get(); 
                    if(count($reservations_count) != 0) $delete_list[] = $count;
                }else $delete_list[] = $count; 
            }else $delete_list[] = $count;
            $count++;
        }
            
        // 備品一覧から対象の備品を削除する
        for($i = 0; $i < count($delete_list); $i++) {
            $equipments->pull($delete_list[$i]);
        }

        // 備品一覧の数が必要台数を満たす場合、OKフラグ
        if($request->number <= count($equipments)){
            $empty_check = 1;
        }
        // 満たさない場合、NGフラグ
        else{
            $empty_check = 2;
        }
        
        // ユーザの予約(check状態)を貸出開始日時の昇順で取得
		$reservations_confirm = $user->reservations()->where('status',0)->orderBy('lending_start', 'asc')->get();
        
        // 貸出予約ビューでそれを表示
        return view('reservations.create', [
            'category' => $category,
            'equipments' => $equipments,
            'reservation' => $reservation,
            'empty_check' => $empty_check,
            'reservations_confirm' => $reservations_confirm,
        ]);
    }

    // 貸出予約処理用(予約リスト追加) 
    public function reserve(Request $request)
    {
        $user = \Auth::user(); // 認証済みユーザを取得
        
        // 次画面に入力情報を保持するため
        $reservation = $request;
        
        // カテゴリー一覧をnameの昇順で、「キー:id、値:name」で取得(セレクトボックス用)
		$category = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        
        
        // 念のための空いている備品を再度取得 //
        $equipments = Category::findOrFail($request->category_id)->equipments->where('status',0);
        $count = 0;
        $delete_list[] = "";
        foreach($equipments as $equipment){
            $reservations_count = Reservation::orderBy('lending_start', 'asc')
                ->where('equipment_id', $equipment->id)
                ->where('lending_start','like', $request->reserve_date .'%')
                ->whereTime('lending_start','>=',$request->reserve_time_start)->whereTime('lending_start','<',$request->reserve_time_end)
                ->get();
            if(count($reservations_count) == 0){
                $reservations_count = Reservation::orderBy('lending_start', 'asc')
                    ->where('equipment_id', $equipment->id)
                    ->where('lending_end','like', $request->reserve_date .'%')
                    ->whereTime('lending_end','>=',$request->reserve_time_start)->whereTime('lending_end','<',$request->reserve_time_end)
                    ->get();
                if(count($reservations_count) == 0){
                    $reservations_count = Reservation::orderBy('lending_start', 'asc')
                        ->where('equipment_id', $equipment->id)
                        ->where('lending_start','like', $request->reserve_date .'%')
                        ->whereTime('lending_start','<=',$request->reserve_time_start)->whereTime('lending_end','>',$request->reserve_time_end)
                        ->get();
                    if(count($reservations_count) != 0) $delete_list[] = $count; 
                }else $delete_list[] = $count; 
            }else $delete_list[] = $count;
            $count++;
        }
        for($i = 0; $i < count($delete_list); $i++) {
            $equipments->pull($delete_list[$i]);
        }
        // 空いている備品を再度取得終了 //

        // 備品一覧の数が必要台数を満たす場合、Reservationテーブルにcheck状態で追加
        if($request->number <= count($equipments)){
            $empty_check = 0;
            
            $count = 1; // 要求数分のみ予約するため
            foreach($equipments as $equipment){
                if($count <= $request->number){
                    $reservation_check = new Reservation;
                    $reservation_check->user_id = $user->id;
                    $reservation_check->equipment_id = $equipment->id;
                    $reservation_check->lending_start = $request->reserve_date. ' ' .$request->reserve_time_start;
                    $reservation_check->lending_end = $request->reserve_date. ' ' .$request->reserve_time_end;
                    $reservation_check->status = 0; // check状態
                    //dd($reservation);
                    $reservation_check->save();
                    $count++;
                }
            }
        }
        // 満たさない場合、NGフラグ
        else{
            $empty_check = 2;
        }
        
        // ユーザの予約(check状態)を貸出開始日時の昇順で取得
		$reservations_confirm = $user->reservations()->where('status',0)->orderBy('lending_start', 'asc')->get();
        
        // 貸出予約ビューでそれを表示
        return view('reservations.create', [
            'category' => $category,
            'equipments' => $equipments,
            'reservation' => $reservation,
            'empty_check' => $empty_check,
            'reservations_confirm' => $reservations_confirm,
        ]);
    }
    
    // 貸出予約処理用(確定)
    public function store(Request $request)
    {
        $user = \Auth::user(); // 認証済みユーザを取得
        
        // ユーザの予約(check状態)を貸出開始日時の昇順で取得
		$reservations = $user->reservations()->where('status',0)->orderBy('lending_start', 'asc')->get();
        
        foreach($reservations as $reservation){
            $reservation->status = 1;
            $reservation->save();
        }
        // ユーザ予約状況画面にリダイレクト
        return redirect('/reservations/user');
    }

    // 予約削除処理用
    public function destroy(Request $request, $id)
    {
        $delete_equipment = Reservation::findOrFail($id); // 取得
        $delete_equipment->delete(); //削除

        // リダイレクト先の指定
        if($request->page == 0) return back();
        else return redirect('/reservations/create');
    }
    
    // 予約全削除処理用
    public function destroy_all(Request $request)
    {
        // 選択された備品を削除
        foreach($request->reservation_id as $reservation_id){
            $delete_equipment = Reservation::findOrFail($reservation_id); // 取得
            $delete_equipment->delete(); //削除
        }

        // 予約画面にリダイレクト
        return redirect('/reservations/create');
    }
    
    // 全体貸出状況画面のフィルタ処理用
    public function filter_index_user(Request $request)
    {
        // 日付と時間からインスタンスを生成
        $datetime = new Carbon($request->filter_date);
        
        $data = [];
		$user = \Auth::user(); // 認証済みユーザを取得
		$today = Carbon::yesterday('Asia/Tokyo'); // 現在の日時取得
 		$reservations = $user->reservations()->where('status',1)
 		    ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
 		    ->orderBy('lending_start', 'asc')->paginate(10);
		$data = [
			'user' => $user,
			'reservations' => $reservations,
			'datetime' => $datetime,
			'today' => $today,
		];
		
		return view('reservations.index_user', $data); // lendings/userビューでそれらを表示
    }
    
    // 全体貸出状況画面のフィルタ処理用
    public function filter_index_all(Request $request)
    {
        // 日付と時間からインスタンスを生成
        $datetime = new Carbon($request->filter_date. ' '. $request->filter_time_start);
        $aftertime = $request->filter_time_end;

        // カテゴリー名
        $categories = Category::orderBy('name', 'asc')->paginate(10);
        
        // カテゴリーの備品類
        foreach($categories as $category){
            $equipments = $category->equipments->where('status',0);
            $count = 0; // 初期化
            $reserved_list = [];
            foreach($equipments as $equipment){
                $reservations_count = Reservation::orderBy('lending_start', 'asc')
                    ->where('equipment_id', $equipment->id)
                    ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
                    ->whereTime('lending_start','>=',$datetime->format('H:i'))->whereTime('lending_start','<',$aftertime)
                    ->get();
                if(count($reservations_count) == 0){
                    $reservations_count = Reservation::orderBy('lending_start', 'asc')
                        ->where('equipment_id', $equipment->id)
                        ->where('lending_end','like', $datetime->format('Y-m-d'). '%')
                        ->whereTime('lending_end','>=',$datetime->format('H:i'))->whereTime('lending_end','<',$aftertime)
                        ->get();
                    if(count($reservations_count) == 0){
                        $reservations_count = Reservation::orderBy('lending_start', 'asc')
                            ->where('equipment_id', $equipment->id)
                            ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
                            ->whereTime('lending_start','<=',$datetime->format('H:i'))->whereTime('lending_end','>',$aftertime)
                            ->get();
                        if(count($reservations_count) != 0) $reserved_list[] = $count;
                    }else $reserved_list[] = $count; 
                }else $reserved_list[] = $count;
                $count++;
            }
            if($reserved_list == null){
                $reserve_ok[] = count($equipments);
                $reserve_ng[] = 0;
            } 
            else{
                $reserve_ok[] = count($equipments) - count($reserved_list);
                $reserve_ng[] = count($reserved_list);
            }
            $total[] = count($equipments);
            
        }

        return view('reservations.index_all', [
            'categories' => $categories,
            'reserve_oks' => $reserve_ok,
            'reserve_ngs' => $reserve_ng,
            'totals' => $total,
            'datetime' => $datetime,
            'aftertime' => $aftertime,
        ]);
    }
    
    // カテゴリー別貸出状況画面のフィルタ処理用
    public function filter_index_category(Request $request)
    {
        $datetime = new Carbon($request->filter_date);
        
        // カテゴリー一覧をnameの昇順で、「キー:id、値:name」で取得(セレクトボックス用)
		$category = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
		
		// カテゴリーに属する備品一覧
		$query = Equipment::orderBy('name', 'asc')->where('status',0)->where('category_id', $request->category);
		$equipments = $query->paginate(10);
		
		// 時間表示
		$month = ['09','10','11','12','13','14','15','16','17','18','19','20','21','22']; // 時
		$minute = ['00','30']; // 分
		
		for($i = 0; $i < count($month); $i++){
		    $time[] = $month[$i]. ':'. $minute[0]; 
		    $time[] = $month[$i]. ':'. $minute[1];
		}
		
		// 各備品の予約時間を取得
		$count = 0;
		foreach($equipments as $equipment){
		    $reserved_list[$count] = [];
		    for($i = 0; $i < count($time)-1; $i++){
    		    $reserved_check = Reservation::orderBy('lending_start', 'asc')
                    ->where('equipment_id', $equipment->id)
                    ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
                    ->whereTime('lending_start','>=',$time[$i])->whereTime('lending_start','<',$time[$i+1])
                    ->get();
                if(count($reserved_check) == 0){
                    $reserved_check = Reservation::orderBy('lending_start', 'asc')
                        ->where('equipment_id', $equipment->id)
                        ->where('lending_end','like', $datetime->format('Y-m-d'). '%')
                        ->whereTime('lending_end','>=',$time[$i])->whereTime('lending_end','<',$time[$i+1])
                        ->get();
                    if(count($reserved_check) == 0){
                        $reserved_check = Reservation::orderBy('lending_start', 'asc')
                        ->where('equipment_id', $equipment->id)
                        ->where('lending_start','like', $datetime->format('Y-m-d'). '%')
                        ->whereTime('lending_start','<=',$time[$i])->whereTime('lending_end','>',$time[$i+1])
                        ->get();
                    }
                }
                if(count($reserved_check) != 0) $reserved_list[$count][] = 1; 
                else $reserved_list[$count][] = 0;
		    }
            $count++;
		}
		
		return view('reservations.index_category', [
            'category' => $category,
            'equipments' => $equipments,
            'time' => $time,
            'id'=> $request->category,
            'datetime' => $datetime,
            'reserved_list' => $reserved_list,
        ]);
    }
    
    
}
