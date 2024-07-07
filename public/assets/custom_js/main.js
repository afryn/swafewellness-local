
// LOGIN FORM 

const baseUrl = $('#burl').val();

function showAlert(msg, swicon) {
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
    

$('#loginForm').on('submit', function (){
    var formData = new FormData(this);
    $.ajax({
        url: baseUrl + "login-account",
        type: "POST",
        data: formData,
        contentType: false, // Set content type to false, jQuery will automatically detect it
        processData: false, // Prevent jQuery from processing the data (FormData does the job)
        success: function (response) {
            // Handle the response from the server after successful submission
            // console.log(response); 
            var data = JSON.parse(response)
            if(data.msg != ''){
              if(data.status){
                showAlert(data.msg, 'success');
              }
              else{
                showAlert(data.msg, 'error');
              }
               
            }
            if(data.status){
                window.location.href = baseUrl + 'admin'
            }
        },
        error: function (xhr, status, error) {
            // Handle any errors that occurred during the AJAX request
            console.error(error);
        },
    });
})

