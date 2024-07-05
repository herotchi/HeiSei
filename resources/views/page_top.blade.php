<!-- トップへ戻るボタン -->
<a href="#" class="pagetop">
    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 18 18">
        <title>Page Top</title>
        <path fill-rule="evenodd" d="M9 5.795c-.316 0-.634.1-.9.3l-4 3c-.662.497-.797 1.437-.3 2.1.498.662 1.437.796 2.1.3L9 9.17l3.1 2.325c.665.496 1.603.362 2.1-.3.497-.663.362-1.603-.3-2.1l-4-3c-.266-.2-.584-.3-.9-.3"></path>
    </svg>
</a>

<script>
// セレクタ名（.pagetop）に一致する要素を取得
const pagetop_btn = document.querySelector(".pagetop");

// .pagetopをクリックしたら
pagetop_btn.addEventListener("click", scroll_top);

// ページ上部へスムーズに移動
function scroll_top() {
    window.scroll({ top: 0, behavior: "smooth" });
}

// スクロールされたら表示
window.addEventListener("scroll", scroll_event);
function scroll_event() {
    if (window.pageYOffset > 100) {
        pagetop_btn.style.opacity = "1";
    } else if (window.pageYOffset < 100) {
        pagetop_btn.style.opacity = "0";
    }
}
</script>

<style>
.pagetop {
    cursor: pointer;
    position: fixed;
    right: 30px;
    bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    transition: .3s;
    color: #00A6C4;
    background: #fff;
    
    /*   デフォルトは非表示 */
    opacity: 0;
}
.pagetop:hover {
    box-shadow: 0 0 10px #00A6C4;
}
</style>