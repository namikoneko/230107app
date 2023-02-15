Vue.component('header-nav', {
    data() {
        return {
            baseUrl: "/230107/",
            yahooUrl: "https://www.yahoo.co.jp/"
        }
    },
    template: `<div class="bg-white px-2 mt-2 rounded d-flex justify-content-between align-middle">

    <h1 class="mb-0 fs-3 logo">
        <a class="text-decoration-none" href='/230107/datasTop'>230107アプリ</a>
    </h1>

    <ul class="nav">

      <li class="nav-item">
        <a class="nav-link" v-bind:href='yahooUrl'>yahoo</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" v-bind:href='baseUrl + "datasTop"'>topレベルへ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" v-bind:href='baseUrl + "datasTop?filter=LvOne"'>レベル1へ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" v-bind:href='baseUrl + "datasTop?filter=LvSort"'>レベルソート</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" v-bind:href='baseUrl + "datasTop?filter=kzm"'>kzmへ</a>
      </li>

    </ul>

</div>
`
})

//コンポーネントの定義、サンプル
Vue.component('button-counter', {
    data() {
        return {
            count: 0
        }
    },
    template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
})

let app = new Vue({
    el: '#app',
    data() {
        return {
            //isUpdLinked: [],
            isShow: true,
            isAddDelForm: true,
            isUpdForm: true,
            isSearchForm: true,
            isInsForm: true,
            isSearchForm: true,
            isShowLinked: []//変更した
        }
    },
    methods: {
        VueToggleBtn() {
            this.isShow = !this.isShow;
        },
        showAddDelForm() {
            this.isAddDelForm = !this.isAddDelForm;
        },
        showUpdForm() {
            this.isUpdForm = !this.isUpdForm;
        },
        showSearchForm() {
            this.isSearchForm = !this.isSearchForm;
        },
        showInsForm() {
            this.isInsForm = !this.isInsForm;
        },
        showSearchForm() {
            this.isSearchForm = !this.isSearchForm;
        },

        //toggleLinked(id) {
        //        //alert();
        //    if (this.isShowLinked[id] == undefined) {
        //            this.isShowLinked.splice(id, 1, true);
        //            console.log("a");
        //            console.log(id);

        //        } else {
        //            this.isShowLinked.splice(id, 1, undefined);
        //            console.log("b");
        //        }
        //},
        //preventHandler(e) {
        //    e.preventDefault();
        //}

        
        //showUpdLinked(id) {
        //    //alert();
        //    //console.log(this.isUpdLinked[id]);
        //    if (this.isUpdLinked[id] == undefined) {
        //        console.log("true!");
        //        console.log(this.isUpdLinked[id]);

        //        this.isUpdLinked[id] = true;
        //    } else {
        //        //console.log("false!");

        //        this.isUpdLinked[id] = !this.isUpdLinked[id];
        //    }
        //},

    }
})






let toggleBtns = document.getElementsByClassName("toggleBtn");
toggleBtns = Array.from(toggleBtns);

let isToggle = false;

toggleBtns.forEach(function (toggleBtn) {
    toggleBtn.addEventListener("click", function () {
        //alert();
        isToggle = !isToggle;
        if (isToggle) {
            this.parentElement.nextElementSibling.style.display = "block";//trueの場合
        } else {
            this.parentElement.nextElementSibling.style.display = "none";//false
        }//if
    });
});
