/*
 * Dikembangkan oleh :
 *  1. Tri Hargianto ( trihargianto@gmail.com )
 *  2. Isnan Agung Saputro ( isnan145@gmail.com )
 *
 */

window.onpopstate = function(event) {
    $("#primarycontent").load(location.href);
}
/*
$(function(){  
  datepicker_format(); enter_src();
  $(".price").on('keyup', function(){priceCurrency});priceCurrency();
  nav_url(); dropdown_tahun(); validation();

  //action alert
  flash_alerts();

  $("#dd_tahun").on("change", function(){
    dropdown_tahun(this.value);
  });

  $('#myModal2').on('show', function() {
    $('#myModal').css('opacity', .5);
  });
  $('#myModal2').on('hidden', function() {
      $('#myModal').css('opacity', 1);
  });
});

$(document).ajaxStart(function(){
    $("#pageload").show();
});

$(document).ajaxStop(function(){
  $("#pageload").hide();
  datepicker_format();  $(".price").on('keyup', function(){priceCurrency});priceCurrency();
  dropdown_tahun($("#dd_tahun").val());validation();
});

$(document).ajaxComplete(function(){
  $(".price").on('keyup', function(){priceCurrency});priceCurrency();
  datepicker_format(); nav_url(); dropdown_tahun($("#dd_tahun").val());
  validation();

  //action alert
  flash_alerts(); enter_src();
});

// var loading   = '<img src="'+site+'assets/loading.gif" style="margin-top:-3px;"> Please wait ..';
*/
/*--------------MODAL--------------------------*/
function ajax_modals(title, dta, address, attrs) {
  if(attrs != undefined){$('#modalcontent').attr('style', attrs);} else{$('#modalcontent').removeAttr('style');}
  $('#myModalLabel').text(title);
  $('#modal-teks').html('');   
  $.ajax({
    type:'POST', data:dta, url:site+address, success:function(i){
      $('#modal-teks').html(i);
      $('#myModal').modal('show'); 
    }
  });
}

function ajax_modals2(title, dta, address, attrs) {
  if(attrs != undefined){$('#modalcontent2').attr('style', attrs);} else{$('#modalcontent2').removeAttr('style');}
  $('#myModalLabel2').text(title);
  $('#modal-teks2').html('');
  $.ajax({
    type:'POST', data:dta, url:site+address, success:function(i){
      $('#modal-teks2').html(i);
      $('#myModal2').modal('show');
    }
  });
}
/*--------------END MODAL--------------------------*/

/*--------------AJAX DATA--------------------------*/
function ajax_data(dta, address) {
  var result = "";
  $.ajax({
    type:'POST', data:dta, url:site+address, async:false, success:function(datas){
      result = datas;
    }
  });
  return result;
}

function eksekusi(url, bid, dta) {
  bid = bid == undefined ? 'primarycontent' : bid;
  var url = url.replace(site, '');

  $.ajax({
    type:'POST', data:dta, url:site+url, success:function(i) {
      $("#"+bid).html(i);
      
      if(window.location != site+url) {
        window.history.pushState({path: "+window.location+"}, "", site+url);
      }

    }
  });
}

function eksekusi_form(url, bid, dta) {
  bid = bid == undefined ? 'primarycontent' : bid;
  var url = url.replace(site, '');

  $.ajax({
    type:'POST', data:dta, url:site+url, success:function(i) {
      $("#"+bid).val(i);
      
      if(window.location != site+url) {
        window.history.pushState({path: "+window.location+"}, "", site+url);
      }

    }
  });
}

function aksi(url, bid, dta) {
  bid = bid == undefined ? 'primarycontent' : bid;

  $.ajax({
    type:'POST', data:dta, url:site+url, success:function(i) {
      $("#"+bid).html(i);
    }
  });
}

function tampil(url, tampil) {
  tampil = tampil == undefined ? 'primarycontent' : tampil;

  $("#"+tampil).load(site+url);

  if(window.location != site+url) {
    window.history.pushState({path: "+window.location+"}, "", site+url);
  }
}

function submit_form(formId, bidLoading, reload, mode, bid, modal2_only) {
  tinyMCE.triggerSave();
  if(formId != undefined) {
    var dta = $("#"+formId).serialize();
    var url_address = $("#"+formId).attr('action');
  } else {
    var dta = $('form').serialize();
    var url_address = $('form').attr('action');
  }

  bid = (bid == undefined) ? 'primarycontent' : bid;
  mode = (mode == undefined) ? 'eksekusi' : mode;

  $('#'+bidLoading).html(loading);

  $.ajax({
    type:'POST',
    data:dta,
    url:url_address,
    success:function(i) {
      var pch = i.split("|||||");

      if(pch[0] == 'sukses') {

        if(reload != undefined)
        {
          if(mode == 'eksekusi')
          {
            eksekusi(reload, bid);
          }
          else
          {
            $("#"+bid).load(site+reload);
          }
        }
        else
        {
          $('#'+bid).html(pch[1]);
        }

        if (modal2_only == undefined)
        {
          $('#myModal2').modal('hide');
          $('#myModal').modal('hide');
        }
        else
        {
          $('#myModal2').modal('hide');
        }
        
      } else {

        alert(pch[0]);

      }

      $('#'+bidLoading).html('');
    }
  });
}

function submit_form_file(formId, bidLoading, reload) {
  tinyMCE.triggerSave();
  if(formId != undefined) {
    var url_address = $("#"+formId).attr('action');
  } else {
    var url_address = $('form').attr('action');
  }

  if(formId == 'formtambah_upload') {
    var fname = 'file_tambah';
  } else if(formId == 'formedit_upload') {
    var fname = 'file_edit';
  } else {
    var fname = 'file';
  }

  $.ajax({
    url: url_address,
    type: "POST",
    contentType: false,
    processData: false,
    data: function() {
      var data = new FormData();
      data.append("file", $("."+fname).get(0).files[0]);
      return data;
    }(),
    success: function(i){
      submit_form(formId, bidLoading, reload);
    }
  });
}

function submit_form_file_iframe(formId, bidLoading, reload, div_id, mode, bid) {
    
    tinyMCE.triggerSave();
    $('#' + bidLoading).html(loading);

    // Create the iframe...
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id", "upload_iframe");
    iframe.setAttribute("name", "upload_iframe");
    iframe.setAttribute("width", "0");
    iframe.setAttribute("height", "0");
    iframe.setAttribute("border", "0");
    iframe.setAttribute("style", "width: 0px; height: 0px; border: none;display:none;");

    // Add to document...
    document.getElementById(formId).parentNode.appendChild(iframe);
    window.frames['upload_iframe'].name = "upload_iframe";

    iframeId = document.getElementById("upload_iframe");

    // Add event...
    var eventHandler = function () {

        if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
        else iframeId.removeEventListener("load", eventHandler, false);

      // Message from server...
        if (iframeId.contentDocument) {
            content = iframeId.contentDocument.body.innerHTML;
        } 
        else if (iframeId.contentWindow) {
            content = iframeId.contentWindow.document.body.innerHTML;
        } 
        else if (iframeId.document) {
            content = iframeId.document.body.innerHTML;
        }

        document.getElementById(div_id).innerHTML = content;

        // Del the iframe...
        setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);

        // penanganan
        var respon = $("#" + div_id).html();
        if(respon == 'sukses')
        {
            var mode    = (mode == undefined) ? 'eksekusi' : mode;
            var bid     = (bid == undefined) ? 'primarycontent' : bid;

            $('#myModal').modal('hide');

            if(mode == 'eksekusi')
                eksekusi(reload, bid);
            else if(mode == 'aksi')
                aksi(reload, bid);
            else if(mode == 'load')
                location.href=site + reload;
        }
        else {

            alert(respon);
        }

        $('#'+bidLoading).html('');
    }

    if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
    if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);

    // Set properties of form with id = formId
    document.getElementById(formId).setAttribute("target", "upload_iframe");
    document.getElementById(formId).setAttribute("method", "post");
    document.getElementById(formId).setAttribute("enctype", "multipart/form-data");
    document.getElementById(formId).setAttribute("encoding", "multipart/form-data");

    // Submit form with id = formId
    document.getElementById(formId).submit();   
}

/*--------------END AJAX DATA--------------------------*/

/*--------------PLUGIN--------------------------*/
function priceCurrency() {
  $(".price").priceFormat({
    prefix: '',
    centsLimit: '0',
    thousandsSeparator: '.',
    allowNegative: true
  });
}

/*function datepicker_format() {
  $(".timepicker").timeEntry({
      show24Hours: true
    });
  
  $( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true,
    cache: false,
    dateFormat : "dd-mm-yy"
  });

  $( ".datepicker_to" ).datepicker( "option", "minDate", $(".datepicker_from").val());
  $( ".datepicker_from" ).datepicker( "option", "maxDate", $(".datepicker_to").val());

  $( ".datepicker_from" ).datepicker({
    changeMonth: true,
    changeYear: true,
    cache: false,
    dateFormat : "dd-mm-yy",
    onClose: function( selectedDate ) {
      $( ".datepicker_to" ).datepicker( "option", "minDate", selectedDate );
    }
  });

  $( ".datepicker_to" ).datepicker({
    changeMonth: true,
    changeYear: true,
    cache: false,
    dateFormat : "dd-mm-yy",
    onClose: function( selectedDate ) {
      $( ".datepicker_from" ).datepicker( "option", "maxDate", selectedDate );
    }
  });  
}*/

function scroll_table() {
  $(function(){
    $('.table-scroll').tableScroll({
      flush: true,
      width: '100%',
      height: '235',
      containerClass: 'tablescroll'
    });
  });
}
/*--------------END PLUGIN--------------------------*/

function temp_upload(id, id_pre, maxSize, attr)
{
    $("#" + id).on("change", function(){

        $('#'+ id_pre).html(loading);

        var files = !!this.files ? this.files : [];

        if(!files.length || !window.FileReader) return;

        if (maxSize != undefined) {
            if (files[0].size > maxSize) {                

                var sizes = maxSize/1000;
                
                alert('Ukuran maksimal file adalah '+ sizes +' Kb, Coba ganti dengan yang lebih kecil');
                $('#'+ id).val('');
                $('#'+ id_pre).html('');
                return true;
            }
        }

        if(/^image/.test(files[0].type)) {
            var reader = new FileReader();

            if(attr == undefined)
              attr = 'width="150"';

            reader.readAsDataURL(files[0]);

            reader.onloadend = function() {
                $("#" + id_pre).html('<img '+ attr +' src="' + this.result + '">');
            }
        }
    });
}

function flashdata(nid)
{
  nid = nid == undefined ? 'msgshowhide' : nid;
  $("#" + nid).show().delay(2000).slideUp(500);

  window.setTimeout("$('#flash_alert').html('')", 3500);
}

function nav_url() {

    var url     = ""+window.location+"";
    var url     = url.replace(""+site+"", "");
    var url     = url.split('undefined').join("");
    var qs      = url.split("?");
    var url     = qs[0];
    var link    = url.split("/");

    var nlink1  = (link[0] == undefined) ? "" : link[0].split("_").join(" ");
    var nlink2  = (link[1] == undefined) ? "" : link[1].split("_").join(" ");
    var nlink3  = (link[2] == undefined) ? "" : link[2].split("_").join(" ");

    nlink2 = nlink2 == 'pelanggan' ? 'Member' : (nlink2 == 'point' ? 'Generate Point' : nlink2);
   
    var link1   = '<button class="btn-link" style="text-decoration:none;color:#FFF; text-transform:capitalize;font-size:12px" onClick=\'eksekusi("'+link[0] + (qs[1] != undefined ? '?'+qs[1] : '') +'")\' title="'+nlink1+'">'+nlink1+'</button>';

    if(nlink2 == "") {
        var link2   = "";
    }
    else {
        var link2   = ' <i class="icon-share-alt"></i> <button class="btn-link" style="text-decoration:none;color:#FFF; text-transform:capitalize;font-size:12px" onClick=\'eksekusi("'+link[0]+"/"+link[1]+ (qs[1] != undefined ? '?'+qs[1] : '') +'")\' title="'+nlink2+'">'+nlink2+'</button>';
    }

    if(nlink3 == "") {
        var link3   = "";
    } 
    else {
        var ptg     = url.replace(link[0] + '/' + link[1] + '/' + link[2]);
        var ptg     = ptg.split('undefined').join("");

        if(ptg == undefined)
            var link3   = ' <i class="icon-share-alt"></i> <button class="btn-link" style="text-decoration:none; color:#FFF; text-transform:capitalize;font-size:12px" onClick=\'eksekusi("'+link[0]+"/"+link[1]+"/"+link[2]+ (qs[1] != undefined ? '?'+qs[1] : '') +'")\' title="'+nlink3+'">'+nlink3+'</button>';

        else
            var link3   = ' <i class="icon-share-alt"></i> <button class="btn-link" style="text-decoration:none; color:#FFF; text-transform:capitalize;font-size:12px" onClick=\'eksekusi("'+link[0]+"/"+link[1]+"/"+link[2]+ptg+ (qs[1] != undefined ? '?'+qs[1] : '') +'")\' title="'+nlink3+'">'+nlink3+'</button>';
    }

    var name_link   = link1+link2+link3;

    $("#hal_title").html(name_link);
}

function popup_window(url, width, height) {
  var x = screen.width/2 - width/2;
  var y = screen.height/2 - height/2;
  window.open(site+url, '','height='+height+',width='+width+',left='+x+',top='+y);
}

function editor(val) {
  tinymce.init({
    selector: ".tinymce",
    skin : 'xenmce',
    resize : false,
    plugins: [
        "advlist autolink lists link charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime table contextmenu paste image"
    ],
    toolbar: "fullscreen | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image"
  });
}

function hapus_data(url, reload, bid)
{
  bid = bid == undefined ? 'primarycontent' : bid ;
  var run = ajax_data('', url);
  eksekusi(reload, bid)
}

function flash_alerts()
{
  if($("#flash_alert").html() != '')
  {
    var ret = "<p></p><div class='alert alert-success' id='msgshowhide'>";
    ret += "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
    ret += $("#flash_alert").html() + "</div>";

    
    $("#flash_alert").html(ret);

    flashdata();
  }
}

function dropdown_tahun(year)
{ 
    if(year == undefined)
    {
        if($("#dd_tahun").attr("data") > "0")
        {
            var year = $("#dd_tahun").attr("data");
        }
        else
        {
            var date = new Date();
            var year = date.getFullYear();
        }
    }

    var akhir = eval(year)-eval(7);
    var awal  = eval(year)+eval(7);

    var daftar  = '';
    for(var i=awal; i>=akhir; i--)
    {
        daftar += '<option ' + (i == year ? 'selected="selected"' : '') + ' value="' + i + '"">' + i + '</option>';
    }

    $('#dd_tahun').html(daftar);
}

function qrcode(url, selector, size, color, background)
{
    selector    = (selector == undefined) ? 'qrcode' : selector;
    size       = (size == undefined) ? 200 : size;
    color       = (color == undefined) ? '3a3' : color;

    $('#' + selector).qrcode({
        "render": "image",
        "background": background,
        "ecLevel": 'L',
        "size": size,
        "color": "#" + color,
        "text": url
    });
}

function scroll_top(id, class_a, class_b, no)
{
    var $sidebar   = $("#" + id), 
        $window    = $(window),
        offset     = $sidebar.offset();

    no          = (no == undefined) ? 0 : no;

    $window.scroll(function() {
        var jarak = $window.scrollTop() - offset.top;

        if(jarak >= no)
        {
            $sidebar.addClass(class_a);

            if(class_b != undefined)
                $sidebar.removeClass(class_b);
        }
        else if(jarak < no)
        {
            $sidebar.removeClass(class_a);

            if(class_b != undefined)
                $sidebar.addClass(class_b);
        }
    });
}

function valid_email(email)
{
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    return regex.test(email);
}

function validation()
{
  $(".number").on("keypress", function(event) {
    var char = event.charCode;
    
    if((char>=48 && char<=57) || char==0 || (char>=44 && char<=46))
      return true;
    else
      return false;

  }); 
}

function enter_src() {

  $("#primarycontent").find("input.src").each(function(index, elem) {
    $(elem).on("keyup", function(e){
      if(e.which == 13) {
        $("#primarycontent").find("button.btn_src").each(function(idx, el) {
          $(el).click();
        });
      }
    });
  });

  $("#myModal").find("input.src").each(function(index, elem) {
    $(elem).on("keyup", function(e){
      if(e.which == 13) {
        $("#myModal").find("button.btn_src").each(function(idx, el) {
          $(el).click();
        });
      }
    });
  });

  $("#myModal2").find("input.src").each(function(index, elem) {
    $(elem).on("keyup", function(e){
      if(e.which == 13) {
        $("#myModal2").find("button.btn_src").each(function(idx, el) {
          $(el).click();
        });
      }
    });
  });
}