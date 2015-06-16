(function($){
    $.fn.siteSearch = function(Setting){
        var siteData = []
        var url = $(this).attr("data-url")
        var me = this

        $.ajax({
                url: url,
                dataType: "xml",
                async: false,
                success:callback
            }
        )

        function callback(xml){
            xmlToObjectArray(xml)
            formTableSubmit()
        }

        // 显示全部视频条目
        function fullText () {
            var regArrayAll = []
            $.each(siteData, function (n, v) {
                    regArrayAll.push(this)
            })
            return regArrayAll
        }

        //    全站搜索
         function fullTextSearch (keyword) {
            var reg = new RegExp(keyword)
            var regArray = []
            $.each(siteData, function (n, v) {
                if (reg.test(this.time) || reg.test(this.content)) {
                    regArray.push(this)
                }
            })
            return regArray
        }

        //    将xml转换为对象的数组
         function xmlToObjectArray (xml) {
            var json = []
            $(xml).find("*:first").children().each(function (i) {
                var obj = {area: $(this).find("area").text(), content: $(this).find("content").text(), url: $(this).find("url").text(),time:$(this).find("time").text(), key: $(this).find("key").text()}
                json.push(obj)
            })
             siteData = json
        }

        //    绑定搜索输入框获取输入框内容
        function  formTableSubmit() {
            $(this).submit(function (e) {
                e.preventDefault();
                //searchKey=$(me).find("input[id='search_value']").val()
                if($("#area1").length > 0){
                    area1=$(me).find("input[id='area1']").val().replace(/(^\s*)|(\s*$)/g, "")
                    date1=$(me).find("input[id='date1']").val()
                    searchKey=area1+date1
                var regArray = fullTextSearch(searchKey)
                }
                else{
                var regArray = fullTextSearch($(me).find("input").val())
                }
                if (regArray.length === 0) {
                    //alert("没有搜到任何东西")
                    //return
                }
                review(regArray);
            })
        }
         function review (regArray) {
           if(typeof(Setting.reviewCallback) !== "undefined"){
               Setting.reviewCallback(regArray)
               return
           }
             return regArray
        }

        function reviewAll (regArrayAll) {
           if(typeof(Setting.reviewCallback) !== "undefined"){
               Setting.reviewCallback(regArrayAll)
               return
           }
             return regArrayAll
        }


    }
})(jQuery)
