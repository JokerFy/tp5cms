window.base={
     g_restUrl:'http://tp5cms.cn/',

    getData:function(params){
        if(!params.type){
            params.type='get';
        }
        var that=this;
        // console.log(this.g_restUrl+params.url);
        $.ajax({
            type:params.type,
            url:this.g_restUrl+params.url,
            dataType:'json',
            data:params.data,
            success:function(res){
                params.sCallback && params.sCallback(res);
            },
            error:function(res){

                params.eCallback && params.eCallback(res);
            }
        });
    },

    setLocalStorage:function(key,val){
        var exp=new Date().getTime()+24*60*60*7;  //令牌过期时间
        var obj={
            val:val,
            exp:exp
        };
        localStorage.setItem(key,JSON.stringify(obj));
    },

    getLocalStorage:function(key){
        var info= localStorage.getItem(key);
        if(info) {
            info = JSON.parse(info);
            if (info.exp > new Date().getTime()) {
                return info.val;
            }
            else{
                this.deleteLocalStorage('token');
            }
        }
        return '';
    },

    deleteLocalStorage:function(key){
        return localStorage.removeItem(key);
    }

}
