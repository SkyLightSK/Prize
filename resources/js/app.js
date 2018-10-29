
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(document).ready(function () {

    /**
     * Prize request
     */
    $('#getPrize').on('click', function (e) {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/home",
            method: 'post',
            data: {
              user: $('#userID').attr('data-user-id')
            },
            success: function (res) {
                console.log(res);

                switch (res.prize_type) {
                    case "App\\Money":
                        $('#prizeContent').html('<h1> Your Prize ' + res.value + '$</h1>');
                        $('#userMoney').html(res.total);
                        break;
                    case "App\\Point":
                        $('#prizeContent').html('<h1> Your Prize ' + res.value + ' points</h1>');
                        $('#userPoints').html(res.total);
                        break;
                    case "App\\Gift":
                        $('#prizeContent').html('<h1> Your Prize ' + res.value + '</h1>');
                        $('#userGiftAmount').html(res.total);
                        break;

                }
                $('#refuseBtn').attr('data-prize-id', res.prize_id).fadeIn();
            }
        });

    });


    /**
     * Prize refuse request
     */
    $('#refuseBtn').on('click', function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/home/refuse",
            method: 'post',
            data: {
                user: $('#userID').attr('data-user-id'),
                prize_id: $('#refuseBtn').attr('data-prize-id')
            },
            success: function (res) {
                console.log(res);
                $('#prizeContent').html('<h1 class="text-danger">Refused</h1>');
                $('#userMoney').html(res.total_money);
                $('#userPoints').html(res.total_points);
                $('#userGiftAmount').html(res.total_gifts);
            }
        });

    });

    /**
     * Convert money request
     */
    $('#converMoney').on('click', function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/home/convertMoney",
            method: 'post',
            data: {
                user: $('#userID').attr('data-user-id'),
            },
            success: function (res) {
                console.log(res);
                $('#userMoney').html(res.total_money);
                $('#userPoints').html(res.total_points);
                $('#userGiftAmount').html(res.total_gifts);
            }
        });

    });
});

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });
