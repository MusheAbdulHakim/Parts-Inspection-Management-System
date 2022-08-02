(function (window, undefined) {
  'use strict';

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  $('.alert').delay(3000).fadeOut();
  
  setTimeout(function(){
    feather.replace();
   }, 1000);


  $('body').on('click','#deletebtn',function(){
      var id = $(this).data('id');
      var route = $(this).data('route');
      
      swal.queue([
          {
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              type: "warning",
              showCancelButton: !0,
              confirmButtonText: '<i data-feather="trash" class="me-1"></i> Delete!',
              cancelButtonText: '<i data-feather="x"></i> Cancel!',
              confirmButtonClass: "btn btn-success me-2",
              cancelButtonClass: "btn btn-danger ms-2",
              buttonsStyling: !1,
              preConfirm: function(){
                  return new Promise(function(){
                      $.ajax({
                          url: route,
                          type: "DELETE",
                          data: {"id": id},
                          success: function(){
                              swal.insertQueueStep(
                                  Swal.fire({
                                      title: "Deleted!",
                                      text: "Resource has been deleted.",
                                      type: "success",
                                      showConfirmButton: !1,
                                      timer: 1500,
                                  })
                              );
                              $('#datatable').DataTable().ajax.reload();
                          },
                          error: function(error){
                            var err = JSON.parse(error.responseText);
                            swal.insertQueueStep(
                                Swal.fire({
                                    title: "Error!",
                                    text: err.message,
                                    type: "error",
                                    showConfirmButton: !1,
                                    timer: 2000,
                                })
                            )
                          }
                      })

                  })
              }
          }
      ]).catch(swal.noop);
      feather.replace();
  });  

  

})(window);
