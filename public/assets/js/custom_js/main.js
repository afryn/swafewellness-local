function sweetAlret(msg, swicon) {
  msg = msg;
  swicon = swicon;
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });

  Toast.fire({
    icon: swicon,
    title: msg,
  });
}

function confirmDialog(title, message, onConfirm) {
  $("#layout-wrapper").addClass("blur");
  var fClose = function () {
    $("#confirmModal").hide();
    $("#layout-wrapper").removeClass("blur");
  };
  $("#confirmMessage").empty().append(message);
  $("#modalTitle").empty().append(title);

  $("#confirmModal").show();

  $("#confirmOk").unbind().one("click", onConfirm).one("click", fClose);
  $("#confirmCancel").unbind().one("click", fClose);
}

function togglePass(inputClass) {
  var passwordInput = $("." + inputClass);
  if (passwordInput.attr("type") === "password") {
    passwordInput.attr("type", "text");
  } else {
    passwordInput.attr("type", "password");
  }
}

function validateimg(ctrl, maxWidth, maxHeight, minWidth, minHeiht) {
  var fileUpload = ctrl;
  // var regex = new RegExp("([a-zA-Z0-9s_\\.-: ])+(.jpg|.png|.gif)$");
  var regex = new RegExp("([a-zA-Z0-9\\s_\\.-:\\\\()])+(.jpg|.png|.gif)$");
// console.log(fileUpload.value)
if(fileUpload.files.length > 8){
  sweetAlret("Can't upload more than 8 images at once.", "warning");
  $(ctrl).val("");
}else{


  for (var i = 0; i < fileUpload.files.length; i++) {
    // console.log(fileUpload.value.toLowerCase())
    if (regex.test(fileUpload.value.toLowerCase())) {
      if (typeof fileUpload.files != "undefined") {
        var reader = new FileReader();
        reader.readAsDataURL(fileUpload.files[i]);
        reader.onload = function (e) {
          var image = new Image();
          image.src = e.target.result;
          image.onload = function () {
            var height = this.height;
            var width = this.width;
            // console.log(height);
            if (minWidth == "" && minHeiht == "") {
              if (height != maxHeight || width != maxWidth) {
                swicon = "warning";
                msg =
                  "Please upload  " +
                  maxWidth +
                  "*" +
                  maxHeight +
                  " photo size.";
                sweetAlret(msg, swicon);
                $(ctrl).val("");
                return false;
              }
            } else {
              if (
                height > maxHeight ||
                width > maxWidth ||
                height < minHeiht ||
                width < minWidth
              ) {
                swicon = "warning";
                msg =
                  "Please upload Max " +
                  maxWidth +
                  "*" +
                  maxHeight +
                  " & Min " +
                  minWidth +
                  "*" +
                  minHeiht +
                  " photo size.";
                sweetAlret(msg, swicon);
                $(ctrl).val("");
                return false;
              }
            }
          };
        };
      } else {
        swicon = "warning";
        msg = "This browser does not support HTML5.";
        sweetAlret(msg, swicon);
        $(ctrl).val("");
        return false;
      }
    } else {
      swicon = "warning";
      msg = "Please select a valid Image file.";
      sweetAlret(msg, swicon);
      $(ctrl).val("");
      return false;
    }
  }
}
}

function number_format_js(number, decimals) {
  // Strip all characters but numerical ones.
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = ',',
      dec = '.',
      s = '',
      toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
      };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function validateMultiplcdfeimg(ctrl, maxWidth, maxHeight, minWidth, minHeiht) {
  var fileUpload = ctrl;
  // var regex = new RegExp("([a-zA-Z0-9s_\\.-: ])+(.jpg|.png|.gif)$");
  var regex = new RegExp("([a-zA-Z0-9\\s_\\.-:\\\\()])+(.jpg|.png|.gif)$");

  console.log(fileUpload.value.toLowerCase());
  if (regex.test(fileUpload.value.toLowerCase())) {
    if (typeof fileUpload.files != "undefined") {
      var reader = new FileReader();
      reader.readAsDataURL(fileUpload.files[i]);
      reader.onload = function (e) {
        var image = new Image();
        image.src = e.target.result;
        image.onload = function () {
          var height = this.height;
          var width = this.width;
          // console.log(height);
          if (minWidth == "" && minHeiht == "") {
            if (height != maxHeight || width != maxWidth) {
              swicon = "warning";
              msg =
                "Please upload  " + maxWidth + "*" + maxHeight + " photo size.";
              sweetAlret(msg, swicon);
              $(ctrl).val("");
              return false;
            }
          } else {
            if (
              height > maxHeight ||
              width > maxWidth ||
              height < minHeiht ||
              width < minWidth
            ) {
              swicon = "warning";
              msg =
                "Please upload Max " +
                maxWidth +
                "*" +
                maxHeight +
                " & Min " +
                minWidth +
                "*" +
                minHeiht +
                " photo size.";
              sweetAlret(msg, swicon);
              $(ctrl).val("");
              return false;
            }
          }
        };
      };
    } else {
      swicon = "warning";
      msg = "This browser does not support HTML5.";
      sweetAlret(msg, swicon);
      $(ctrl).val("");
      return false;
    }
  } else {
    swicon = "warning";
    msg = "Please select a valid Image file.";
    sweetAlret(msg, swicon);
    $(ctrl).val("");
    return false;
  }
}

$(document).on("click", ".modalBtn", function () {
  var html = '<option value="" disabled selected>-- Select --</option>';

  var fullId = $(this).attr('id').split('_');
  var act = fullId[1];
  var id = fullId[2];

  $('#selectedData').val(act)
  $('#selectedId').val(id)

  if ($(this).hasClass("trainer_btn")) {
    
    // select center and programme
    html += '<option value="center">Center</option>';
    html += '<option value="programme">Programme</option>';
    
  } else if ($(this).hasClass("center_btn")) {

    // select trainer and programme
    html += '<option value="programme">Programme</option>';
    html += '<option value="trainer">Trainer</option>';
    
  } else if ($(this).hasClass("program_btn")) {
 
    // select center and trainer
   html += '<option value="center">Center</option>';
    html += '<option value="trainer">Trainer</option>';
  }
  $('#mySelect').html(html)
});

