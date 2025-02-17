
<{$toolbar}>
  <script language='javascript' type='text/javascript' src='<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js'></script>

  <{if $data.kind_in }>
    <!--     輸入                          -->
    <{foreach key=key item=sign from=$data.kind_in }>

      <{assign var="i" value=1 }>
      <{if ($data.admin) }>
        <form action="index.php?id=<{$sign.id }>" method="post">
          <div class='row'>
            <span class='col-2 col-md-2 '>班級：</span>
            <span class='col-4 col-md-4'>
              <{html_options name="admin_class_id" class="form-control" options=$data.class_list_c selected=$data.sel_class onchange="submit();" }>
            </span>
            <span class="alert alert-danger  col-3 col-md-3">管理員權限!!!!</span>
          </div>
        </form>
      <{else}>
          <h3> 班級：
            <{$data.class_list_c[$data.sel_class] }>
          </h3>
      <{/if}>

            <form action="index.php" method="post">
              <fieldset>
                <div class='alert alert-info'>
                    <h3><{$sign.title }></h3>
                    <{$sign.doc|nl2br }>
                </div>
                <!--  尚無輸入資料  -->
                <{if (! $data.my_class) }>
                  <!--  尚無報名資料   -->
                  <div class="alert alert-success">
                    <div>快速輸入區(空白做分隔)，移開後會自動擷取資料，但還未完成報名。</div>
                    <div class="row">
                        <div class="col-6 col-md-6">
                          <input type="text" class="form-control"   id="q_input" placeholder="輸入學生座號，多人時以空白分隔" data="<{$sign.get_data_item}>" title='有修改，移開後會自動擷取資料。'>
                        </div>
                        <div class="col-6  col-md-6">
                          <span class="btn btn-primary">取資料</span>
                          <span class='btn btn-success' onclick='javascript:input_all();' id="btn_all" data="<{$sign.get_data_item}>" title='把全班的學生座號全部填報，用於全體調查表'>全班都填</span>
                        </div>
                    </div>
                  </div>
                <{/if}>
                    <!--    輸入欄          -->
                  <h5>正取資料輸入(直接輸入座號，自動轉換姓名)</h5>
                    <div class="row">
                      <span class="basge badge-info bg-info col-4  col-md-4"> 順序. 座號</span>
                      <{foreach key=key item=fi from=$sign.field_input }>
                      <span class="basge badge-info bg-info col-<{$fi[3]}>  col-md-<{$fi[3]}>">
                          <{$fi[1]}>
                      </span>
                        <{/foreach}>
                      <span class="basge badge-info bg-info col-4  col-md-4">匯出資料欄</span>
                    </div>


                    <{section name=ti start=0 loop=$sign.stud_get step=1 }>

                      <div class="row" ord_id="<{$i}>">
                        <span class="col-4 col-md-4">
                          <input class="form-control sitid"  id="sitid_<{$i}>" name="num_id[<{$i}>]" value="<{$data.my_class[$data.sel_class][$i].stud_name }>" type="text" title="<{$i}>.座號才能擷取出資料" placeholder="<{$i}>.座號或姓名" data="<{$sign.get_data_item}>">
                        </span>
                        <!--     需輸入欄         -->
                        <{foreach key=key item=fi from=$sign.field_input }>
                          <{if ($fi[2]=='d' ) }>
                            <!--     日期       -->
                            <span class=" col-<{$fi[3]}> col-md-<{$fi[3]}>">
                              <input class="form-control self_input" dmode="<{$fi[2]}>" name="in_<{$fi[0]}>[<{$i}>]" type="text" title="<{$fi[1]}>" placeholder="<{$fi[1]}>"
                              <{if $data.my_class[$data.sel_class][$i].stud_name }>
                              <{assign var="bar" value="in_<{$fi[0]}>" }>
                                value="<{$data.my_class[$data.sel_class][$i][$bar] }>"
                              <{else}>
                                value="<{$fi[4]}>"
                              <{/if}>
                                onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" mode="<{$fi[2]}>">
                            </span>
                          <{elseif ($fi[2]=='o' ) }>
                              <!--     下拉       -->
                              <span class="col-<{$fi[3]}>  col-md-<{$fi[3]}> ">
                                <{if $data.my_class[$data.sel_class][$i].stud_name }>
                                  <{assign var="bar" value="in_<{$fi[0]}>" }>
                                  <{assign var="my_selected" value=$data.my_class[$data.sel_class][$i][$bar] }>
                                <{else}>
                                  <{assign var="my_selected" value=0 }>
                                <{/if}>
                                <{html_options name="in_<{$fi[0]}>[<{$i}>]" options=$fi[5] selected=$my_selected class="form-control self_input" }>
                              </span>
                         <{else}>
                                <span class="col-<{$fi[3]}> col-md-<{$fi[3]}>">
                                  <input class="form-control self_input" dmode="<{$fi[2]}>" name="in_<{$fi[0]}>[<{$i}>]" type="text" title="<{$fi[1]}>" placeholder="<{$fi[1]}>"
                                  <{if ($data.my_class[$data.sel_class][$i].stud_name) }>
                                    <{assign var="bar" value="in_<{$fi[0]}>" }>
                                    value="<{$data.my_class[$data.sel_class][$i][$bar] }>"
                                  <{else}>
                                        value="<{$fi[4]}>"
                                  <{/if}>
                                            mode="<{$fi[2]}>">
                                </span>
                         <{/if}>
                        <{/foreach}>
                                    <!--     擷取欄         -->
                        <span class="col-4 col-md-4" id="get_<{$i}>">
                              <{$data.my_class[$data.sel_class][$i].get_hide }>
                        </span>

                      </div>
                      <!-- <{$i++}> -->
                      <{/section }>

                        <!--    備取區          -->
                        <{if ($sign.stud_get_more) }>
                          <h5>備取資料輸入(直接輸入座號修改)</h5>
                          <{section name=ti start=0 loop=$sign.stud_get_more step=1 }>

                            <div class="row" ord_id="<{$i}>">

                              <span class="col-4 col-md-4">
                                <input class="form-control sitid" id="sitid_<{$i}>" name="num_id[<{$i}>]" value="<{$data.my_class[$data.sel_class][$i].stud_name }>" type="text" title="<{$i}>.座號才能擷取出資料" placeholder="<{$i}>.座號或姓名" data="<{$sign.get_data_item}>">
                              </span>
                              <!--     需輸入欄(由報名報)         -->
                              <{foreach key=key item=fi from=$sign.field_input }>
                                <{if ($fi[2]=='d' ) }>
                                  <!--     日期欄         -->
                                  <span class="col-<{$fi[3]}> col-md-<{$fi[3]}>">
                                    <input class="form-control self_input" dmode="<{$fi[2]}>" name="in_<{$fi[0]}>[<{$i}>]" type="text" title="<{$fi[1]}>" placeholder="<{$fi[1]}>"
                                    <{if $data.my_class[$data.sel_class][$i].stud_name }>
                                      <{assign var="bar" value="in_$fi[0]" }>
                                      value="<{$data.my_class[$data.sel_class][$i][$bar] }>"
                                    <{else}>
                                      value="<{$fi[4]}>"
                                    <{/if}>
                                    onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" mode="<{$fi[2]}>">
                                  </span>
                                  <{elseif ($fi[2]=='o' ) }>
                                    <{if $data.my_class[$data.sel_class][$i].stud_name }>
                                      <{assign var="bar" value="in_$fi[0]" }>
                                        <{assign var="my_selected" value=$data.my_class[$data.sel_class][$i][$bar] }>
                                          <{else}>
                                            <{assign var="my_selected" value=0 }>
                                              <{/if}>
                                                <span class="col-<{$fi[3]}> col-md-<{$fi[3]}>">
                                                  <{html_options name="in_$fi[0][$i]" options=$fi[5] selected=$my_selected class="form-control self_input" }>
                                                </span>

                                                <{else}>
                                                  <span class="col-<{$fi[3]}>  col-md-<{$fi[3]}>">
                                                    <input class="form-control self_input" dmode="<{$fi[2]}>" name="in_<{$fi[0]}>[<{$i}>]" type="text" title="<{$fi[1]}>" placeholder="<{$fi[1]}>" <{if $data.my_class[$data.sel_class][$i].stud_name }>
                                                    <{assign var="bar" value="in_$fi[0]" }>
                                                      value="<{$data.my_class[$data.sel_class][$i][$bar] }>"
                                                        <{else}>
                                                          value="<{$fi[4]}>"
                                                            <{/if}>
                                                              mode="<{$fi[2]}>">
                                                  </span>
                                                  <{/if}>
                                                    <{/foreach}>
                                                      <!--     擷取欄         -->
                                                      <span class="col-4 col-md-4" id="get_<{$i}>">
                                                        <{$data.my_class[$data.sel_class][$i].get_hide }>
                                                      </span>

                            </div>
                            <!-- <{$i++}> -->
                            <{/section }>
                              <{/if}>
                                <input type='hidden' name='now_class' value='<{$data.sel_class }>'>
                                <input type='hidden' name='now_kind' value='<{$sign.id }>'>
                                <input type='hidden' name='input_data_item' value='<{$sign.input_data_item }>'>
                                <input type='hidden' name='get_data_item' value='<{$sign.get_data_item}>'>
                                <input type='hidden' name='studs_get' value='<{$sign.stud_get }>'>
                                <input type='hidden' name='studs_more' value='<{$sign.stud_get_more }>'>
                                <button type="submit" class="btn btn-success" name='ADD' value='add'>報名完成</button>
                                <{if (! $data.my_class) }>
                                  <!--  尚無報名資料   -->
                                  <button type="submit" class="btn btn-danger" name='Submit_emp' value='empt' title="如果班上沒有學生符合或要參加，按下這鍵代表貴班已填報過了的記號。">班上沒有學生要報名</button>
                                  <{/if}>
              </fieldset>
            </form>

            <{/foreach}>

              <script>
                function IsNumeric(num) {
                  return (num >= 0 || num < 0);
                }

                //由座號，擷取資料
                $(function() {
                  $(".sitid").change(function() {
                    var tid = $(this).attr('id');
                    var sit_id = $(this).val();
                    var get_f = $(this).attr('data');
                    //alert (sit_id) ;
                    getdata( <{$data.sel_class}> , tid, sit_id, get_f);
                  });
                });

                $(function() {
                  $(".sitid").focus(function() {
                    $(this).select();
                  });
                });

                function input_all() {
                  var sit_id = '<{$data.class_sit_num_list}>';
                  var get_f = $('#btn_all').attr('data');
                  //alert(get_f) ;
                  var splits = sit_id.split(" ");
                  for (var i in splits) {
                    var j = i;
                    var ii = j * 1 + 1;
                    //alert( ii + '    '+ splits[i]) ;
                    getdata( <{$data.sel_class }> , 'sitid_' + ii, splits[i], get_f);
                  }
                }

                function getdata(class_id, tid, sit_id, get_f) {
                  //alert(class_id +' '+  tid + ' ' +sit_id +get_f) ;
                  if (!IsNumeric(sit_id)) return;
                  var splits = tid.split('_');
                  var iid = splits[1];
                  $.ajax({
                      url: 'ajax_get_stud_data.php',
                      type: 'GET',
                      dateType: 'json', //接收資料格式
                      data: {
                        class_id: class_id,
                        class_sit_id: sit_id,
                        tid: tid,
                        fi: get_f
                      },
                    })
                    .done(function(data) {
                      //console.log("success");
                      //取得 json 格式
                      var json_obj = jQuery.parseJSON(data);
                      //alert( iid + json_obj.name) ;
                      //更改姓名、擷取資料
                      $("#sitid_" + iid).val(json_obj.name);
                      $("#get_" + iid).html(json_obj.html);
                      //alert(data) ;
                    })
                    .fail(function() {
                      console.log("error");
                    })
                    .always(function() {
                      console.log("complete");
                    });


                }

                //由快速報名，擷取資料
                $(function() {
                  $("#q_input").change(function() {

                    var sit_id = $(this).val();
                    var get_f = $(this).attr('data');
                  //  alert(get_f ) ;
                    var splits = sit_id.split(" ");
                    for (var i in splits) {
                      var j = i;
                      var ii = j * 1 + 1;
                      //alert( ii + '    '+ splits[i]) ;
                      getdata( <{$data.sel_class  }> , 'sitid_' + ii, splits[i], get_f);
                    }
                  });
                });

                //清除單筆報名記錄----------------------------------------------------------------------------------
                $(document).on("click", ".del", function() {

                  var iid = $(this).parent().parent().attr("ord_id");
                  //清除
                  $("#sitid_" + iid).val("");
                  $("#get_" + iid).html("");

                });

                //檢查是否為數字

                $(function() {
                  $(".self_input").change(function() {
                    var dtype = $(this).attr("dmode");
                    //alert (dtype) ;
                    if (dtype == "n") {
                      var input = $(this).val();
                      if (!IsNumeric(input))
                        alert('欄位內容需要為數字，請再次檢查！');
                    }

                  });
                });
              </script>



              <{else}>
                <!--     列出總表                      -->
                <{if (! $data.kind ) }>
                  <h1>還沒有報名表</h1>
                  <{/if}>
                    <{assign var="i" value=1 }>
                      <{foreach key=key item=sign from=$data.kind }>
                        <div class="row">
                        <{if ($sign.cando) }>


                            <span class=" col-1 col-md-1">
                              <{if ($sign.need) }>
                                <{if ($sign.inputed) }>
                                  <a class="btn btn-info" href="index.php?id=<{$sign.id}>" title="已填寫過，再次修正！">修改</a>

                                <{else}>
                                    <a class="btn btn-success" href="index.php?id=<{$sign.id}>" title="第一次輸入！">報名</a>
                                <{/if}>
                              <{else}>
                                        <span class="basge badge-default bg-secondary" title="所在的年級無需填報">無需填報</span>
                              <{/if}>
                            </span>

                            <{else }>

                                <span class=" col-1 col-md-1">
                                  <span class="basge badge-dark bg-dark ">過期</span>
                                </span>
                                <{/if}>

                                  <span class="col-5 col-md-5">
                                    <div class="alert alert-info">
                                      <span class="badge badge-info bg-info">
                                        <{$sign.id}>
                                      </span>
                                      <{$sign.title}>
                                    </div>
                                    <div class="offset-md-1">
                                      <{$sign.doc|nl2br}>
                                    </div>
                                  </span>
                                  <span class=" col-2 col-md-2">
                                    <{$sign.admin}>

                                  </span>
                                  <span class="col-3 col-md-3">
                                  <{if ($sign.d_days>0) }>
                                    <span class="basge badge-info bg-info">還有
                                      <{$sign.d_days}> 天</span>
                                    <span> 填報年級：
                                      <{$sign.input_classY}>
                                    </span>
                                    <{/if}>
                                </span>

                              </div>
                              <hr />
                              <{/foreach}>


                                <{/if}>
