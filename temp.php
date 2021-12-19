<script>
  $(document).ready(function() {
    //set initial state.
 		
    $('input[name=check]').change(function() {
      var yourArray = [];
      $("input:checkbox[name=check]:checked").each(function(){
        yourArray.push($(this).val());
        });
      console.log(yourArray);
      });
    });
</script>