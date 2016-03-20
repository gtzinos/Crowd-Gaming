/*
  On focus change
  hide other tooltips
*/
$("gt-input-group").on("focusout",function() {
  $("[data-toggle='tooltip']").tooltip("hide");
});

/*
  When window loaded
*/
$(window).on('load', function() {
  /*
    Focus the first input element
    from the document form
    *We need this to call focus event
    to check the fields
  */
  $(document).find("form:not(.filter) :input:visible:enabled:first").focus();
});
/*
  When a modal box will open
*/
$('.modal').on('shown.bs.modal', function() {
    /*
      Focus the first input element
      from the modal form
      *We need this to call focus event
      to check the fields
    */
    $('.modal').find("form:not(.filter) :input:visible:enabled:first").focus();
});

/*
  When a modal box will close
  we must focus something
  if we have a form
  *We need this to call focus event
  to check the fields
*/
$('.modal').on('hidden.bs.modal', function() {
  /*
    If we have a form back
    of this modal
  */
   if($(document).find("form:not(.filter) :input:visible:enabled:first"))
   {
     /*
       Focus the first input element
       if we have a page form
     */
     $(document).find("form:not(.filter) :input:visible:enabled:first").focus();
   }
});
