$(function() {

    if (!window.base.getLocalStorage('token')) {
        window.location.href = 'login.html';
    }

    /*退出*/
    $(document).on('click','#login-out',function(){
        window.base.deleteLocalStorage('token');
        window.location.href = 'login.html';
    });

})