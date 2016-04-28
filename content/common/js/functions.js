


function fun_NavActive(){
    
    var uri = document.documentURI;
    uri=fun_getUriQuery(uri);
    var d=fun_getElementsByClassTagName('collapse','div')[0];
    var l=d.getElementsByTagName('li');
    var llen=l.length;

    for(var i=0;i<llen;i++){
        var la=l[i];
        la=la.getElementsByTagName('a');
        var lalen=la.length;

        for(var ii=0;ii<lalen;ii++){
            var lahref=la[ii].href;
            lahref=fun_getUriQuery(lahref);

            if(lahref==uri && uri.charAt(uri.length-1)!='#') {
                l[i].setAttribute('class','active');
            }else{
                if(uri.indexOf(lahref)!=-1){
                    
                    if(uri.substr(0,uri.length-(uri.length-uri.indexOf('#')))==lahref){
                        l[i].setAttribute('class','active');
                    }else if(uri=='/index.php'){
                        if(lahref=='/'){
                            l[i].setAttribute('class','active');
                        }
                    }
                }
            }

        }
    }
}


/**
 * @note 获取uri的query参数 比如 http://www.gioov.com/index/home 获取的是index/home ; http://www.gioov.com/?c=index 获取的是 ?c=indexmn
 * @param uri
 * @returns {string|*}
 */
function fun_getUriQuery(uri) {
    
    var t=uri.indexOf('//');
    if(t!=-1) {
        uri = uri.substr(t + 2, uri.length - t);
        t = uri.indexOf('/');
        if(t!=-1) {
            uri = uri.substr(t, uri.length - t);
            return uri;
        }
    }
}



function hasClass(tagStr, classStr) {
    var arr = tagStr.className.split(/\s+/); //这个正则表达式是因为class可以有多个,判断是否包含 
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] == classStr) {
            return true;
        }
    }
    return false;
}

//获取标签类 <div class="className"></div>
function fun_getElementsByClassTagName(classStr, tagName) {
    if (document.getElementsByClassName) {
        return document.getElementsByClassName(classStr)
    } else {
        var nodes = document.getElementsByTagName(tagName), ret = [];
        for (i = 0; i < nodes.length; i++) {
            if (hasClass(nodes[i], classStr)) {
                ret.push(nodes[i])
            }
        }
        return ret;
    }
}

/**
 * @note 显示模态框
 * @param prefix 模态框默认前缀
 * @param title 模态框标题
 * @param body 模态框主体信息
 * @param hideTodoFunction 模态框隐藏执行函数
 */
function showModal(prefix,title,body,hideTodoFunction){
    if(prefix==''){
        $('#modal_tipTitle').html('');
        $('#modal_tipBody').html('');
        $('#modal_tipTitle').html(title);
        $('#modal_tipBody').html(body);
        $('#modal_tipModal'+prefix).modal('show');
        $('#modal_tipModal').on('hide.bs.modal', hideTodoFunction);
    }else{
        $('#modal_tipTitle'+prefix).html('');
        $('#modal_tipBody'+prefix).html('');
        $('#modal_tipTitle'+prefix).html(title);
        $('#modal_tipBody'+prefix).html(body);
        $('#modal_tipModal'+prefix).modal('show');
        $('#modal_tipModal'+prefix).on('hide.bs.modal', hideTodoFunction);
    }
}