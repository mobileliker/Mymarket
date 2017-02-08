/*
 * @version: 1.0 公共通用的js文件
 * @author: 苏锐佳
 * @build: 2016/08/05
 * @description:
 */

/**
 * @version: 1.1 公共通用的js文件
 * @author: 苏锐佳
 * @build: 2016/08/19
 * @description: 新增通用ajax对象
 */

/**
 * @version: 1.2 公共通用的js文件
 * @author: 苏锐佳
 * @build: 2016/08/31
 * @description: 重构paging对象
 */

/**
 * @version: 1.3 公共通用的js文件
 * @author: 苏锐佳
 * @build: 2016/09/03
 * @description: 为paging对象新增异步刷新本页的功能
 */


/*--------------------Global variable begin------------*/
//通用ajax
var easyAjax = {};
//layui-layer 数组
var arrLayer = [];
/*--------------------Global variable end------------*/


/*--------------------Script entry begin------------*/
$(function () {
    paging = new Paging();
    paging.ajaxPage();
    layer.closeAllLayer = function () {
        arrLayer.length = 0;
        layer.closeAll();
    };
});
/*--------------------Script entry end------------*/


/*--------------------Customize object begin------------*/

/**
 * 异步分页类
 * @author 苏锐佳
 * @param pageParams
 * @constructor
 */
function Paging(pageParams) {

    // 第一个值为列表项id
    // 第二个值为tmpl模板id
    // 第三个值为后台传过来的数据的键名
    // 第四个值为分页器父元素id
    this.pageParams = pageParams;

    //记录上一个传递过来的参数
    this.cacheParams = pageParams;

    //是否执行callBack函数的判断，默认为true，执行callBack函数
    this.isCallBack = true;

    //用于使事件只绑定一次的标志
    this.flag = true;

    //保留本次url或uri
    this.urlCache = "";


    /**
     * 设置参数，同时解除事件绑定
     * @method setParams
     * @param pageParams 参数
     */
    if (Paging.prototype.setParams == undefined) {
        Paging.prototype.setParams = function (pageParams) {
            this.cacheParams = (this.pageParams == undefined ? pageParams : this.pageParams);
            this.pageParams = pageParams;
            $("#" + (this.cacheParams == undefined || this.cacheParams.length < 4 ? 'page-content' : this.cacheParams[3]))
                .off("click", "ul li a");
            this.flag = true;
        }
    }

    /**
     * 设置urlCache属性
     * @method setUrlCache
     * @param urlCache url或uri
     */
    if (Paging.prototype.setUrlCache == undefined) {
        Paging.prototype.setUrlCache = function (urlCache) {
            this.urlCache = urlCache;
        }
    }

    /**
     * 获取本对象实例
     * @method getPaging
     * @return Object {Object} Paging实例对象
     */
    if (Paging.prototype.getPaging == undefined) {
        Paging.prototype.getPaging = function () {
            return this;
        }
    }

    /**
     *分页器事件绑定函数
     * @method paginatorOn
     */
    if (Paging.prototype.paginatorOn == undefined) {
        Paging.prototype.paginatorOn = function () {
            var object = this;
            $("#" + (this.pageParams == undefined || this.pageParams.length < 4 ? 'page-content' : this.pageParams[3]))
                .on("click", "ul li a", object, function () {
                    object.pagination($(this).attr('title'), object);
                });
        }
    }
    /**
     * go分页初始化
     */
    if (Paging.prototype.initGo == undefined) {
        var params = new Array();
        var flag=0;
        Paging.prototype.initGo = function (listnum) {
            flag++;
            var len=this.urlCache.length-(this.urlCache.lastIndexOf("=")+1);
            params[0] = this.urlCache.substring(0, this.urlCache.length - len);  //删除等号后面的数据
            var setval=setflag(params[0]);
            if(setval!="false") {
                params[0] = this.urlCache.substring(0, this.urlCache.length - len);
                params[1] = this;
            } else {
                if(flag%2==0) {
                    params[1] = this;
                }
                else if(flag%2!=0){
                    params[2] = this;
                }
            }
            var goButton = "";
            // var goButton = '<div class="paging-skip"><div><input class="val" type="text"><em class="btn btn-go" onclick="">GO</em></div></div>';
            $("#" + (this.pageParams == undefined || this.pageParams.length < 4 ? 'page-content' : this.pageParams[3])).after(goButton);
            $("#" + (this.pageParams == undefined || this.pageParams.length < 4 ? 'page-content' : this.pageParams[3]) + "+div")
                .on('click', 'em', params, function () {
                    var page = $(this).prev().val();
                    if (page == '') {
                        layer.msg('请输入页数');
                        return false;
                    }
                    if(parseInt(page)>(parseInt(listnum/10)+1)) {
                        layer.msg('当前页码数大于总页码数');
                        $(this).prev().val('');
                        return false;
                    }
                    if(setval!="false") {
                        params[1].pagination(params[0] + page, params[1]);
                    }
                    else {
                        params[1].pagination(params[0] + page, params[1]);
                        params[2].pagination(params[0] + page, params[2]);
                    }
                });
        }
    }
    
    
    /**
     * 数据渲染成功后必执行的回调函数
     * @method callBack
     * @param params 参数
     */
    Paging.prototype.callBack = function (params) {

    }

    /**
     * 分页异步化
     * @method ajaxPage
     */
    if (Paging.prototype.ajaxPage == undefined) {
        Paging.prototype.ajaxPage = function () {
            var paginationHtml = $("#" + (this.pageParams == undefined || this.pageParams.length < 4 ? 'page-content' : this.pageParams[3]) + " .pagination").prop('outerHTML');
            if (paginationHtml != undefined) {
                var result = this.RegxReplace(paginationHtml);
                $("#" + (this.pageParams == undefined || this.pageParams.length < 4 ? 'page-content' : this.pageParams[3])).children().remove();
                $("#" + (this.pageParams == undefined || this.pageParams.length < 4 ? 'page-content' : this.pageParams[3])).append(result);

                if (this.flag) {
                    this.paginatorOn();
                    this.flag = false;
                }
            }
        }
    }

    /**
     *分页数据拼接方式,可自定义
     * @method appendPage
     * @param {Object} ret 后台返回的json数据
     */
    if (Paging.prototype.appendPage == undefined) {
        Paging.prototype.appendPage = function (ret) {
            $('#' + this.pageParams[0]).children().remove();
            $("#" + this.pageParams[1]).tmpl(ret[this.pageParams[2]]['data']).appendTo('#' + this.pageParams[0]);
        }
    }

    /**
     *根据后台返回的json数据异步刷新列表数据和分页器
     * @method flashPaginator
     * @param {Object} ret 后台返回的json数据
     * @param callBackParams 必执行的回调函数的参数
     * @param successBefore {function} 在callBack函数之前执行的函数
     * @param successAfter {function} 在callBack函数之后执行的函数
     */
    if (Paging.prototype.flashPaginator == undefined) {
        Paging.prototype.flashPaginator = function (ret, successBefore, successAfter) {
            var paginationHtml = ret['links'];//获取分页栏目
            var listnum=this.pageAndAll(ret);
            var result = this.RegxReplace(paginationHtml);
            $("#" + (this.pageParams == undefined || this.pageParams.length < 4 ? 'page-content' : this.pageParams[3])).children().remove();
            $("#" + (this.pageParams == undefined || this.pageParams.length < 4 ? 'page-content' : this.pageParams[3])).append(result);
            this.appendPage(ret);
            if (this.flag) {
                this.paginatorOn();
                this.flag = false;
            }
            $("#" + (this.pageParams == undefined || this.pageParams.length < 4 ? 'page-content' : this.pageParams[3]) + "+div").remove();
            if (result != '') {
                this.initGo(listnum);
            }
            if (successBefore != undefined) {
                successBefore();
            }

            if (paging.isCallBack) {
                this.callBack();
            }

            if (successAfter != undefined) {
                successAfter();
            }
        }
    }
    /**1
     * 回收站还原固定还原列
     * @method restore
     * @param
     */
    if (Paging.prototype.restore == undefined) {
        Paging.prototype.restore = function () {
            if (paging.isCallBack) {
                this.callBack('deleted_at');
            }
        }
    }
    

    /**
     * 正则替换
     * @method RegxReplace
     * @param {string} origin pagination类的outerHTML
     * @returns {string|XML|*}
     * @constructor
     */
    if (Paging.prototype.RegxReplace == undefined) {
        Paging.prototype.RegxReplace = function (origin) {
            //中间替换结果
            var transition = '';
            //最后替换结果
            var result = '';
            //保留本次url或uri
            var urlCache = '';
            //当前分页的下标
            var pageIndex = '';
            //匹配<a href="http://www.xxxxx.com/xxx/xxx?xxx&page=x"
            var regxUrl = /<a href="([a-zA-z]*:\/\/)?[^\s]*page=[0-9]+"/g;
            //匹配<li class="active"><span>xx
            var regxIndex = /<li class="active"><span>[0-9]+/g;
            //匹配<a href="http://www.xxxxx.com
            var regxL = /<a href="(\w+):\/\/([^/:]+)(:\d*)?/g;

            //获取匹配结果
            var tmp = origin.match(regxL);
            var urlCacheTmp = origin.match(regxUrl);
            var pageIndexTmp = origin.match(regxIndex);

            //获取当前分页的下标
            if (pageIndexTmp != null) {
                pageIndex = pageIndexTmp[0].substring(25);
            }
            //获取本次url或uri
            if (urlCacheTmp != null) {
                urlCache = urlCacheTmp[0].substring(9, urlCacheTmp[0].indexOf("page=") + 5) + pageIndex;
            }
            if (tmp == null) {
                //一开始刚加载的a标签的href里的链接不带有域名，故需使用不同的正则表达式来替换
                var regxStr = /<a href="?/g;
                tmp = origin.match(regxStr);
                transition = origin.replace(regxStr, '<a href="javascript:void(0)" title="\/');
                urlCache = "/" + urlCache;
            } else {
                transition = origin.replace(regxL, '<a href="javascript:void(0)" title="');
            }
            if (urlCache.indexOf("&amp;") > 0) {
                urlCache = urlCache.replace(/&amp;/g, "&");
            }
            this.setUrlCache(urlCache);
            // 经过上面的替换后变成
            // <a href="javascript:void(0)" title="uri?参数;page=分页下标">
            var regxR = /([0-9]{1,4})"/g;
            result = transition.replace(regxR, '$1\"');

            if (tmp == null && urlCacheTmp == null && pageIndexTmp == null) {
                result = '';
                this.setUrlCache(origin);
            }
            return result;
        }
    }

    /**
     *分页异步请求函数
     * @method pagination
     * @param url {string} url请求
     */
    if (Paging.prototype.pagination == undefined) {
        Paging.prototype.pagination = function (url, object) {
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function (ret) {
                    goMethod(ret);
                    object.flashPaginator(ret);
                    if(url.indexOf("deleted_at") > 0) {
                        object.restore();
                    }
                },
                error: function () {
                    layer.msg("error");
                }
            });
        }
    }

    /**1
     * 使用缓存的url或自定义url异步刷新列表数据和分页器
     * @method flashThePaginator
     * @param url {string} url请求
     */
    if (Paging.prototype.flashThePaginator == undefined) {
        Paging.prototype.flashThePaginator = function (url) {
            this.pagination((url == undefined || url == "" ? this.urlCache : url), this.getPaging());
        }
    }
    /**1
     * 使用刷新列表获取总是和页数
     * @method pageAndAll
     * @param ret
     */
    if (Paging.prototype.pageAndAll == undefined) {
        Paging.prototype.pageAndAll = function (ret) {
            var arr = new Array();
            for (var key in ret) {
               arr.push(key);
            }
            page4=this.pageParams.length < 4 ? 'page-content' : this.pageParams[3];
            page=ret[arr[0]]['last_page'];
            total=ret[arr[0]]['total'];
            if((this.pageParams['2']=='cultivates')||(this.pageParams['2']=='breeds')) {
                if(total<=10) {
                    $('.culPagingChange').css('display','none');
                }
                else {
                    $('.culPagingChange').css('display','block');
                }
            }
            $("#"+page4).parent().find('small').children('strong').eq(0).html(page);
            $("#"+page4).parent().find('small').children('strong').eq(1).html(total);
            return total;
        }
    } 
}

/**
 * 通用ajax对象
 * @type {{prex: string, get: easyAjax.get, post: easyAjax.post, index: easyAjax.index, create: easyAjax.create, store: easyAjax.store, show: easyAjax.show, edit: easyAjax.edit, update: easyAjax.update, destroy: easyAjax.destroy, batchDestroy: easyAjax.batchDestroy, check: easyAjax.check, query: easyAjax.query, queryWithParams: easyAjax.queryWithParams}}
 */
easyAjax = {

    //url的前缀
    prex: 'c',

    /**
     * 通用get方法
     * @param url {string} 不带前缀的url
     * @param params 参数
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param prex {string} 不填则使用通用的url前缀
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    get: function (url, params, successFun, errorFun, callbackCustParam, prex, async) {
        $.ajax({
            url: '/' + (prex == undefined ? this.prex : prex) + '/' + url,
            type: 'GET',
            data: {params: params},
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        });
    },

    /**
     * 通用post方法
     * @param url {string} 不带前缀的url
     * @param params 参数
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param prex {string} 不填则使用通用的url前缀
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    post: function (url, params, successFun, errorFun, callbackCustParam, prex, async) {
        $.ajax({
            url: '/' + (prex == undefined ? this.prex : prex) + '/' + url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                params: params
            },
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        });
    },

    /**
     * 获取分页后的列表项
     * @param url {string} 资源控制器名
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    index: function (url, successFun, errorFun, callbackCustParam, async) {
        $.ajax({
            url: '/' + this.prex + '/' + url + '/query',
            type: 'GET',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        });
    },

    create: function (url, successFun, errorFun, callbackCustParam, async) {
        $.ajax({
            url: '/' + this.prex + '/' + url + '/create',
            type: 'GET',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        });
    },
    
    postForm: function(url,params,formId, successFun, errorFun, callbackCustParam, prex, async) {
        options={
            url: '/' + (prex == undefined ? this.prex : prex) + '/' + url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                params: params
            },
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        };
        $("#" + formId).ajaxSubmit(options);
    },

    /**
     * 新增一条记录，附带验证
     * @param url {string} 资源控制器名
     * @param formId {string} 表单id
     * @param rules 表单验证规则
     * @param messages 验证规则对应的错误提示
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     * @param resetForm {boolean} 是否在提交后重置表单数据，true为重置，false为不重置，默认true
     */
    store: function (url, formId, rules, messages, successFun, errorFun, callbackCustParam, async, resetForm) {
        options = {
            success: successFun,
            error: errorFun,
            url: '/' + this.prex + '/' + url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            resetForm: resetForm == undefined ? true : resetForm,
        };
        $("#" + formId).validate({
            rules: rules,
            messages: messages,
            errorPlacement: function (error, element) {
                showValidateWrongMsg(element[0]['attributes']['id']['value'], error[0]['innerText']);
            },
            onfocusout: function () {
                ret = $("#" + formId).validate();
                cleanOneValidateWrongMsg(ret);
            },
            submitHandler: function () {
                cleanAllValidateWrongMsg();
                $("#" + formId).ajaxSubmit(options);
            }
        });
    },

    /**
     * 显示一条记录的信息
     * @param url {string} 资源控制器名
     * @param id {string} 记录的id
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    show: function (url, id, successFun, errorFun, callbackCustParam, async) {
        $.ajax({
            url: '/' + this.prex + '/' + url + '/' + id,
            type: 'GET',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        });
    },

    /**
     * 获取一条待编辑记录的信息
     * @param url {string} 资源控制器名
     * @param id {string} 记录的id
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    edit: function (url, id, successFun, errorFun, callbackCustParam, async) {
        $.ajax({
            url: '/' + this.prex + '/' + url + '/' + id + '/edit',
            type: 'GET',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        });
    },

    /**
     * 更新一条记录的信息，附带验证
     * @param url {string} 资源控制器名
     * @param formId {string} 表单id
     * @param objectId {string} 记录的id
     * @param rules 表单验证规则
     * @param messages 验证规则对应的错误提示
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     * @param resetForm {boolean} 是否在提交后重置表单数据，true为重置，false为不重置，默认true
     */
    update: function (url, formId, objectId, rules, messages, successFun, errorFun, callbackCustParam, async, resetForm) {
        options = {
            success: successFun,
            error: errorFun,
            url: '/' + this.prex + '/' + url + '/' + objectId,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: "PUT"
            },
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            resetForm: resetForm == undefined ? true : resetForm,
        };
        $("#" + formId).validate({
            rules: rules,
            messages: messages,
            errorPlacement: function (error, element) {
                showValidateWrongMsg(element[0]['attributes']['id']['value'], error[0]['innerText']);
            },
            onfocusout: function () {
                ret = $("#" + formId).validate();
                cleanOneValidateWrongMsg(ret);
            },
            submitHandler: function () {
                cleanAllValidateWrongMsg();
                $("#" + formId).ajaxSubmit(options);
            }
        });
    },

    /**
     * 删除一条记录
     * @param url {string} 资源控制器名
     * @param id {string} 记录的id
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    destroy: function (url, id, successFun, errorFun, callbackCustParam, async) {
        $.ajax({
            url: '/' + this.prex + '/' + url + '/' + id,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: "DELETE"
            },
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            },
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            }
        });
    },

    /**
     * 批量删除多条记录
     * @param url {string} 资源控制器名
     * @param ids 记录的id数组
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    batchDestroy: function (url, ids, successFun, errorFun, callbackCustParam, async) {
        $.ajax({
            url: '/' + this.prex + '/' + url + '/deletes',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ids: ids,
                _method: "DELETE"
            },
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        });
    },

    /**
     * 验证记录中某个字段是否唯一
     * @param url {string} 资源控制器名
     * @param params 数组参数，第一个值为id，第二个值为field，第三个值为value
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    check: function (url, params, successFun, errorFun, callbackCustParam, async) {
        $.ajax({
            url: '/' + this.prex + '/' + url + '/check',
            type: 'GET',
            data: {
                id: params[0],
                field: params[1],
                value: params[2]
            },
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        });
    },

    /**
     * 配置JQuery.Validate.js里面remote字段所需参数
     * @param url {string} 资源控制器名
     * @param params 数组参数，第一个值为id，第二个值为field
     * @returns JQuery.Validate.js里面remote字段所需参数
     */
    remoteCheck: function (url, params) {
        global_params = params;
        var remote = {
            type: "GET",
            url: '/' + this.prex + '/' + url + '/check',
            async: false,
            data: {
                id: function () {
                    return global_params[0];
                },
                field: function () {
                    return global_params[1];
                }
            }
        }
        return remote;
    },

    /**
     * 搜索查询，附带验证
     * @param url {string} 资源控制器名
     * @param formId {string} 表单id
     * @param rules 表单验证规则
     * @param messages 验证规则对应的错误提示
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    query: function (url, formId, rules, messages, successFun, errorFun, callbackCustParam, async) {
        options = {
            success: successFun,
            error: errorFun,
            url: '/' + this.prex + '/' + url + '/query',
            type: 'GET',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
        };

        $("#" + formId).validate({
            rules: rules,
            messages: messages,
            errorPlacement: function (error, element) {
                showValidateWrongMsg(element[0]['attributes']['id']['value'], error[0]['innerText']);
            },
            onfocusout: function () {
                ret = $("#" + formId).validate();
                cleanOneValidateWrongMsg(ret);
            },
            submitHandler: function () {
                cleanAllValidateWrongMsg();
                $("#" + formId).ajaxSubmit(options);
            }
        });
    },

    /**
     * 获取分页后的列表项，带参数
     * @param url {string} 资源控制器名
     * @param params 参数
     * @param successFun 成功时的回调函数，参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param errorFun 发生错误时的回调函数,参数data:请求返回的数据|textStatus:请求的返回状态|custParam:自定义参数，对应callbackCustParam
     * @param callbackCustParam 回调函数中要传递的自定义参数，用于提供回调函数上下文以外的对象。
     * @param async {boolean} 使用异步或同步ajax，true为异步，false为同步，默认true
     */
    queryWithParams: function (url, params, successFun, errorFun, callbackCustParam, async) {
        $.ajax({
            url: '/' + this.prex + '/' + url + '/query',
            type: 'GET',
            data: {params: params},
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            async: async == undefined ? true : async,
            error: function (data, textStatus, errorThrown) {
                errorFun(data, textStatus, callbackCustParam);
            },
            success: function (data, textStatus) {
                successFun(data, textStatus, callbackCustParam);
            }
        });
    }
};

/*--------------------Customize object end------------*/


/*--------------------Customize function begin------------*/

/**
 *使用layer的tip显示输入框的错误提示信息
 * @param id {string} input输入框的id
 * @param msg {string} 错误信息
 */
function showValidateWrongMsg(id, msg) {
    tmp = index = arrLayer.length; //获取数组长度
    flag = false;
    while (index--) { //开始遍历id是否存在于原数组中
        if (arrLayer[index][1] == id) {
            flag = true; //若id存在于原数组中且对应的错误信息一样，则flag为true
            if (arrLayer[index][2] != msg) { //若id存在于原数组中且对应的错误信息不一样
                $("#" + arrLayer[index][0]).remove(); //移除原错误提示
                tmp = index; //记录下标
                flag = false;
            }
            break;
        }
    }
    //判断div隐藏域
    if($('#'+id).is(':hidden')) {
        layer.msg(msg);
        flag = true;
    }
    else {
        if (!flag) {
            layer.tips(msg,
                '#' + id, {
                    tips: [2, background], //还可配置颜色
                    tipsMore: true,
                    time: 0,
                });
            layuiLength = $("div[type='tips']").length; //上面的layer.tips新增一个错误提示后，获取其所有错误提示的数量
            arrLayer[tmp] = [];
            arrLayer[tmp][0] = ($("div[type='tips']")[layuiLength - 1]).getAttribute("id"); //获取最新增加的那个错误提示的div的id
            arrLayer[tmp][1] = id;
            arrLayer[tmp][2] = msg;
        }
    }
}

/**
 * 清除指定id的错误提示信息
 * @param id {String} input输入框的id
 */
function cleanTheValidateWrongMsg(id) {
    tmp = index = arrLayer.length;
    replaceIndex = -1;
    while (index--) { //开始遍历验证成功的input的id是否存在于arrLayer数组中
        if (arrLayer[index][1] == id) { //id存在
            $("#" + arrLayer[index][0]).remove(); //移除对应的错误提示框
            replaceIndex = index; //记录被移除的下标位置
            break;
        }
    }
    if (replaceIndex != -1) {
        //把最后面的值移到被删除的元素的位置，然后删除最后一个
        arrLayer[replaceIndex][0] = arrLayer[tmp - 1][0];
        arrLayer[replaceIndex][1] = arrLayer[tmp - 1][1];
        arrLayer[replaceIndex][2] = arrLayer[tmp - 1][2];
        arrLayer.length = tmp - 1;
    }
}

/**
 * 清除所有错误提示信息
 */
function cleanAllValidateWrongMsg() {
    index = arrLayer.length;
    while (index--) {
        $("#" + arrLayer[index][0]).remove();
    }
    arrLayer.length = 0;
}

/**
 * 清除一条错误提示信息
 * @param ret {object} 验证成功的list对象
 */
function cleanOneValidateWrongMsg(ret) {
    successListLength = ret['successList'].length; //获取验证成功的list的长度
    while (successListLength--) { //开始遍历successList中的每一个验证成功的input的id是否存在于arrLayer数组中
        id = ret['successList'][successListLength]['id']; //获取验证成功的input的id
        cleanTheValidateWrongMsg(id);
    }
}

/**
 * 批量操作方法
 * 陈郑辉 郭森林
 * radio 多选框按钮的name
 * checkbox 全选框的id
 */

var CacheData = new Array();

/*
 *a为全选按钮class
 *b为列表id
 *c为单选按钮class
 *d为显示数量input框id
 **/
function Checks(a,b,c,d) {
    //单选事件
    $("#"+b).on('change', 'tr td .'+c, function () {
        var checkVal = this.checked;//选中状态
        var idVal = $(this).val(); //获取value(id号)
        //判断单选框状态
        if (checkVal) {
            if ($.inArray(idVal, CacheData) == -1) {
                //加入数组
                CacheData.push(idVal);
            }
        } else {
            //遍历数组，判断是否存在数组，则移除数组
            for (var i = 0; i < CacheData.length; i++) {
                if (CacheData[i] == idVal) {
                    CacheData.splice(i, 1);
                }
            }
        }
        //设置显示总条数
        $("#"+d).val(CacheData.length);
    });

    //全选按钮
    $("#"+a).on('change',function () {
        var allCheckde = this.checked;
        $("#"+b+" tr td ."+c).each(function () {
            $(this).prop("checked", allCheckde);//设置单选框状态
            var idVal = $(this).val(); //获取单选框value(数据id号);
            if (allCheckde) {
                if ($.inArray(idVal, CacheData) == -1) {
                    //添加数据到数组
                    CacheData.push(idVal);
                }
            } else {
                //遍历数组，判断当前值来得到下标
                for(var u=0;u<CacheData.length;u++){
                    if(idVal == (CacheData[u])){
                        //根据下标移除数组
                        CacheData.splice(u,1);
                    }
                }
            }
        });
        //设置显示总条数
        $("#"+d).val(CacheData.length);
    });
}

/*
 *批量操作方法，分页回调设置多选框状态
 **/
function CcheckState(x,y) {
    //重置全选按钮
    $("#" + x).prop('checked', false);

    //设置单选框状态
    for (var a = 0; a < CacheData.length; a++) {
        $("." + y + "[value='" + CacheData[a] + "']").attr('checked', true);
    }
    //设置全选框状态
    var m = $("." + y + ":checked").length;
    var n = $("." + y).length;
    if ((m == n)&&(m!=0)) {
        $("#" + x).prop('checked', 'checked');
    }
}
/**
 * 回到上一页
 * 李明村
 * ret 传入列表数值
 */
function goMethod(ret) {
    var arr = new Array();
    for (var key in ret) {
        arr.push(key);
    }
    page=ret[arr[0]]['current_page'];
    total=ret[arr[0]]['total'];
    if((total%10==0)&&($('.cont-title').attr('delete'))) {
        if(page!=1) {
            page=page-1;
            $(".val").val(page);
            $(".btn-go").trigger('click');
        }
    }
    $('.cont-title').removeAttr('delete');
}
function setflag(val) {
    var urlRoute = location.href;
    urlAfter = urlRoute.lastIndexOf("\/");
    str = urlRoute.substring(urlAfter + 1, urlRoute.length);
    if(((val.indexOf('cultivate')>0)&&(str!='cultivate'))||((val.indexOf('harvest')>0)&&(str!='batch'))||(str=='log')) {
        return "true";
    }
    else {
        return "false";
    }
}

//默认当前日期方法
function p(s) {return s < 10 ? '0' + s: s;};
function defaultDate(){
    var myDate = new Date();
    //获取当前年
    var y=myDate.getFullYear();
    //获取当前月
    var m=myDate.getMonth()+1;
    //获取当前日
    var d=myDate.getDate(); 
    var date=y+'-'+p(m)+'-'+p(d);
    return date;
};
//排序公共方法
function publicSort(id,object) {
    $("#"+id).parent().find('thead').children('tr').children('td').on('click',function() {
        arrows=$(this).children('em').html();
        if(arrows!="") {
            var code = arrows.charCodeAt();   // 获得实体编码;
            $("#"+id).parent().find('thead').children('tr').children('td').children('em').html('&darr;');
            if(code!=8595) {
                $(this).children('em').html('&darr;');
                order1='asc';
            }
            else {
                $(this).children('em').html('&uarr;');
                order1='desc';
            }
            _sort=$(this).attr('name');
            object.initGroupSearch(_sort,order1);
        }
    });
}
//导出表格公共方法
function exportExcel(check_id,sid,route,id,state) {
    var ids = Array();
    $("input[name="+check_id+"]:checked").each(function (i) {
        ids[i] = $(this).attr(sid);
    });
    if(ids!='') {
        if((route!='await')) {
            if(id!=undefined) {
                location.href ='http://'+ window.location.host+'/admin/c/'+route+'/excel?ids='+ids+'&id='+id;
            }
            else {
                location.href ='http://'+ window.location.host+'/admin/c/'+route+'/excel?ids='+ids;
            }
        }
        else {
            location.href ='http://'+ window.location.host+'/admin/c/'+route+'/excel?ids='+ids+'&state='+state;
        }
    }
}
//手机端返回页面
function return_prepage()  
{  
    if(window.document.referrer==""||window.document.referrer==window.location.href) { 
        window.location.href="{dede:type}[field:typelink /]{/dede:type}";  
    }
    else {  
        window.location.href=window.document.referrer;  
    }
}
/*--------------------Customize function end------------*/