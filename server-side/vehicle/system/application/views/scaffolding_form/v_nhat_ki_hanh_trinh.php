<html>
    <head>
        <base href="http://localhost/vehicle/">
        <title>Nhat_ki_hanh_trinh</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" type="text/css" media="screen" href="http://localhost/vehicle/resources/jqGrid/themes/basic/grid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="http://localhost/vehicle/resources/theme/ui.all.css"  />
        <link rel="stylesheet" type="text/css" media="screen" href="http://localhost/vehicle/resources/css/main-app.css"  />
        <style type="text/css">
            .toggler { width: 250px; height: 125px; }
            #drop { width: 240px; height: 105px; padding: 0.4em; }
            #drop .ui-widget-header { margin: 0; padding: 0.4em; text-align: center; }
        </style>

        <script type="text/javascript" src="http://localhost/vehicle/resources/jquery-1.3.1.js"></script>
        <script type="text/javascript" src="http://localhost/vehicle/resources/jquery.ui.all.js"></script>
        <script type="text/javascript" src="http://localhost/vehicle/resources/jqGrid/jquery.jqGrid.js"></script>

        <!--  Utils for Page -->
        <script type="text/javascript" src="http://localhost/vehicle/resources/utils/inlinebox.js"></script>
        <script type="text/javascript" src="http://localhost/vehicle/resources/utils/jquery.validate.js"></script>
        <script type="text/javascript" src="http://localhost/vehicle/resources/utils/jquery.maskedinput-1.2.1.pack.js"></script>
        <script type="text/javascript" src="http://localhost/vehicle/resources/utils/jquery.form.js"></script>
        <script type="text/javascript" src="http://localhost/vehicle/resources/utils/jquery.field.min.js"></script>
        <script type="text/javascript" src="http://localhost/vehicle/resources/utils/jquery.autocomplete.js"></script>

        <script  type="text/javascript">
            var Nhat_ki_hanh_trinh = {};

            Nhat_ki_hanh_trinh.data = {};
            Nhat_ki_hanh_trinh.setDataField = function(fieldName,fieldValue)
            {
                Nhat_ki_hanh_trinh.data[fieldName] = fieldValue;
            }

            Nhat_ki_hanh_trinh.setData = function(data)
            {
                jQuery.each(data, function(name, value) {
                    Nhat_ki_hanh_trinh.data[name] = value;
                    $("#main_form input[name="+ name +"]").setValue(value);
                });
            }


            Nhat_ki_hanh_trinh.getData = function()
            {
                var obj = {};
                $.each( $("#main_form").formSerialize().split("&"), function(i,n)
                {
                    var toks = n.split("=");
                    obj[toks[0]] = toks[1];
                }
            );
                Nhat_ki_hanh_trinh.data = obj;
                return Nhat_ki_hanh_trinh.data;
            }

            //create
            Nhat_ki_hanh_trinh.Create = function()
            {
                if(!$("#main_form").valid())
                    return;
                InlineBox.showAjaxLoader();
                jQuery.post("http://localhost/vehicle/index.php/c_nhat_ki_hanh_trinh/create", $("#main_form").formToArray() ,
                function(message){
                    if(message != null){
                        InlineBox.hideAjaxLoader();
                        $("#list2").trigger("reloadGrid");
                        InlineBox.showModalBox("Tạo Nhat_ki_hanh_trinh " + message);
                    }
                });
            }

            //refresh grid
            Nhat_ki_hanh_trinh.Read = function()
            {
                InlineBox.showAjaxLoader();
                jQuery.post("http://localhost/vehicle/index.php/c_nhat_ki_hanh_trinh/read_json_format", {},
                function(data){
                    InlineBox.hideAjaxLoader();
                    $("#list2").trigger("reloadGrid");
                });
            }

            //update
            Nhat_ki_hanh_trinh.Update = function()
            {
                if(!$("#main_form").valid())
                    return;

                InlineBox.showAjaxLoader();
                jQuery.post("http://localhost/vehicle/index.php/c_nhat_ki_hanh_trinh/update", $("#main_form").formToArray() ,
                function(message){
                    InlineBox.hideAjaxLoader();
                    $("#list2").trigger("reloadGrid");
                    InlineBox.showModalBox("Cập nhật Nhat_ki_hanh_trinh " + message);
                });
            }


            //delete
            Nhat_ki_hanh_trinh.Delete = function()
            {
                if(!$("#main_form").valid())
                    return;
                InlineBox.showAjaxLoader();
                jQuery.post("http://localhost/vehicle/index.php/c_nhat_ki_hanh_trinh/delete",$("#main_form").formToArray() ,
                function(message){
                    InlineBox.hideAjaxLoader();
                    $("#list2").trigger("reloadGrid");
                    InlineBox.showModalBox("Xoá Nhat_ki_hanh_trinh " + message);
                });
            }

            Nhat_ki_hanh_trinh.currentRowID = null;

            Nhat_ki_hanh_trinh.setSelectedRow = function(id)
            {
                Nhat_ki_hanh_trinh.currentRowID = id;
            }

            Nhat_ki_hanh_trinh.setSelectedTab = function(){
                $('#container-1 > ul').tabs('select',0);
            }

            Nhat_ki_hanh_trinh.showDiaDiem = function(name){
                window.frames.image_vehicle_iframe.tem = name;
                $('#container-1 > ul').tabs('select',2);
            }

            var inputDate = {};
            $( function() {
                inputDate['NGAY_KHOI_HANH'] = $("#NGAY_KHOI_HANH").datepicker({dateFormat:"yy/mm/dd"});
                $('#NGAY_KHOI_HANH').mask('9999/99/99');
                $('#NGAY_KHOI_HANH').validate({rules:{ require: true, date: true}});
                inputDate['NGAY_KET_THUC_DK'] = $("#NGAY_KET_THUC_DK").datepicker({dateFormat:"yy/mm/dd"});
                $('#NGAY_KET_THUC_DK').mask('9999/99/99');
                $('#NGAY_KET_THUC_DK').validate({rules:{ require: true, date: true}});
                inputDate['NGAY_KET_THUC'] = $("#NGAY_KET_THUC").datepicker({dateFormat:"yy/mm/dd"});
                $('#NGAY_KET_THUC').mask('9999/99/99');
                $('#NGAY_KET_THUC').validate({rules:{ require: true, date: true}});
            });
        </script>
    </head>

    <body>

        <div id="container-1">
            <ul>
                <li><a href="#fragment-1"><span>Thông tin Hành Trình</span></a></li>
                <li><a href="#fragment-2"><span>Danh sách Hành Trình</span></a></li>
                <li><a href="#fragment-3"><span>Quản lý địa điểm </span></a></li>
            </ul>
            <div id="fragment-1">
                <div style="width: 930px;">
                    <div class="box">
                        <h1> Nhật Ký Hành Trình </h1>
                        <hr>

                        <form method="POST" id="form_Nhật Ký HàNh Trình" action="http://localhost/vehicle/index.php/c_nhat_ki_hanh_trinh/">

                            <label>
                                <span>STT</span>
                                <input type="text" name="STT_NKHT" value="" id="STT_NKHT" class="input-text" onchange="Nhat_ki_hanh_trinh.setDataField(this.name,this.value);"  />
                            </label>

                            <label>
                                <span>SO_DANG_KY_XE</span>
                                <input type="text" name="SO_DANG_KY_XE" value="" id="SO_DANG_KY_XE" class="input-text" onchange="Nhat_ki_hanh_trinh.setDataField(this.name,this.value);"  />
                            </label>

                            <label>
                                <span>Tên</span>
                                <input type="text" name="TEN" value="" id="TEN" class="input-text" onchange="Nhat_ki_hanh_trinh.setDataField(this.name,this.value);"  />
                            </label>

                            <label>
                                <span>diemdiemKH</span>
                                <input type="text" name="diemdiemKH" value="" id="diemdiemKH" class="input-text" onclick="Nhat_ki_hanh_trinh.showDiaDiem(this.name);"  />
                            </label>

                            <label>
                                <span>diemdiemKT</span>
                                <input type="text" name="diemdiemKT" value="" id="diemdiemKT" class="input-text" onclick="Nhat_ki_hanh_trinh.showDiaDiem(this.name);"  />
                            </label>

                            <label>
                                <span>Ngày khởi hành</span>
                                <input type="text" name="NGAY_KHOI_HANH" value="" id="NGAY_KHOI_HANH" class="input-text"   />
                            </label>

                            <label>
                                <span>NGAY_KET_THUC_DK</span>
                                <input type="text" name="NGAY_KET_THUC_DK" value="" id="NGAY_KET_THUC_DK" class="input-text" onchange="Nhat_ki_hanh_trinh.setDataField(this.name,this.value);"  />
                            </label>

                            <label>
                                <span>Ngày kết thúc</span>
                                <input type="text" name="NGAY_KET_THUC" value="" id="NGAY_KET_THUC" class="input-text" onchange="Nhat_ki_hanh_trinh.setDataField(this.name,this.value);"  />
                            </label>
                        </form>

                        <div class="spacer" id="form_control" >
                            <a href="javascript:void(0)" onclick="Nhat_ki_hanh_trinh.Create()" class="green">Thêm</a>
                            <a href="javascript:void(0)" onclick="Nhat_ki_hanh_trinh.Update()" class="green">Cập nhập</a>
                            <a href="javascript:void(0)" onclick="Nhat_ki_hanh_trinh.Delete()" class="green">Xoá</a>
                        </div>
                        <div id="ajaxloader" style="display:none" >
                            <img  src="http://localhost/vehicle/resources/css/img/ajax-loader.gif" />
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div id="fragment-2">
                <div>
                    <table id="list2" class="scroll" style="margin-top:8px;" cellpadding="0" cellspacing="0"></table>
                    <div id="pager2" class="scroll" style="text-align:center;"></div>
                </div>
            </div>
            <div id="fragment-3">
                <iframe name='image_vehicle_iframe' id='image_vehicle_iframe' scrolling="auto" style="border: 0px none; width: 880px; height: 780px;" src="http://localhost/vehicle/index.php/c_diadiem/"></iframe>
            </div>
        </div>

    </body>

    <script type="text/javascript">
        // $('#last_activity').val().toString()
        var jGrid = null;
        var colNamesT = new Array();
        var colModelT = new Array();
        var gridimgpath = 'http://localhost/vehicle/resources/jqGrid/themes/basic/images';

        colNamesT.push('STT_NKHT');
        colModelT.push({name:'STT_NKHT',index:'STT_NKHT', editable: false});
        colNamesT.push('SO_DANG_KY_XE');
        colModelT.push({name:'SO_DANG_KY_XE',index:'SO_DANG_KY_XE', editable: false});
        colNamesT.push('TEN');
        colModelT.push({name:'TEN',index:'TEN', editable: false});
        colNamesT.push('diemdiemKH');
        colModelT.push({name:'diemdiemKH',index:'diemdiemKH', editable: false});
        colNamesT.push('diemdiemKT');
        colModelT.push({name:'diemdiemKT',index:'diemdiemKT', editable: false});
        colNamesT.push('NGAY_KHOI_HANH');
        colModelT.push({name:'NGAY_KHOI_HANH',index:'NGAY_KHOI_HANH', editable: false});
        colNamesT.push('NGAY_KET_THUC_DK');
        colModelT.push({name:'NGAY_KET_THUC_DK',index:'NGAY_KET_THUC_DK', editable: false});
        colNamesT.push('NGAY_KET_THUC');
        colModelT.push({name:'NGAY_KET_THUC',index:'NGAY_KET_THUC', editable: false});

        var loadView = function()
        {
            jGrid = jQuery("#list2").jqGrid(
            {
                url:'http://localhost/vehicle/index.php/c_nhat_ki_hanh_trinh/read_json_format',
                mtype : "POST",
                datatype: "json",
                colNames: colNamesT ,
                colModel: colModelT ,
                rowNum:10,
                height: 270,
                rowList:[10,20,30],
                imgpath: gridimgpath,
                pager: jQuery('#pager2'),
                sortname: colNamesT[0],
                viewrecords: true,
                caption:"Nhật ký hành trình",
                onSelectRow: function(){
                    var id = jQuery("#list2").getGridParam('selrow');
                    Nhat_ki_hanh_trinh.setData(jQuery("#list2").getRowData(id));
                }
            });
            jGrid.navGrid('#pager2',{edit:false,add:false,del:false, search: false, refresh: true});
            $("#alertmod").remove();//FIXME
        }
        jQuery("#list2").ready(loadView);


        var initForm = function(){
            //init validation form
            $("#main_form").validate();

            //init input mask
            $('#container-1 > ul').tabs();
        }
        jQuery("#main_form").ready(initForm);

    </script>

    <div class="info-box" id="info-box" style="display:none">
        <div class="toggler">
            <div id="drop" class="ui-widget-content ui-corner-all">
                <h3 class="ui-widget-header ui-corner-all" id="info-box-header">info box</h3>
                <p>
                    <div id="info-box-msg" align="center" style="font-size:13px;font-weight: bold;"> content </div>
                </p>
                <center>
                    <input type="button" value="Đóng" id="inform-box-close" onclick="$('.info-box').toggle('drop')" />
                </center>
            </div>
        </div>
    </div>
</html>