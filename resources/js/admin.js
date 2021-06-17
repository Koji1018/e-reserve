//// 変数 ////

let checkAll = document.getElementById("checkAll"); // 全選択チェックボックス
let el = document.getElementsByClassName("checks"); // 通常チェックボックス
let delete_button = document.getElementById("delete"); // 削除ボタン(本番用)


//// 関数 ////

// (全選択チェックボックス)操作時の機能
const funcCheckAll = (bool) => {
    if (bool) { delete_button_able(); }
    else { delete_button_disable(); }
    for (let i = 0; i < el.length; i++) {
        el[i].checked = bool;
    }
};

// (通常チェックボックス)操作時の機能
const funcCheck = () => {
    let count = 0;
    for (let i = 0; i < el.length; i++) {
        if (el[i].checked) {
            count += 1;
        }
    }
    if (count > 0) { delete_button_able(); }
    else { delete_button_disable(); }
    
    if (el.length === count) {
        checkAll.checked = true;
    } else {
        checkAll.checked = false;
    }
};

// (削除ボタン)アクティブ化
const delete_button_able = () => {
    delete_button.disabled = false;
    delete_button.className = "btn btn-primary btn-block btn-sm";
};

// (削除ボタン)非アクティブ化
const delete_button_disable = () => {
    delete_button.disabled = true;
    delete_button.className = "btn btn-secondary btn-block btn-sm";
};


//// トリガー ////

// (全選択チェックボックス)クリック時
if (checkAll != null) {
    checkAll.addEventListener(
        "click",
        () => {
            funcCheckAll(checkAll.checked);
        },
        false
    );
}

// (通常チェックボックス)クリック時
for (let i = 0; i < el.length; i++) {
    el[i].addEventListener("click", funcCheck, false);
}