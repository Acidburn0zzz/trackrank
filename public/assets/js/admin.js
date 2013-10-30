$('.program_row').click(function() {
  var selector = ".program" + $(this).find("td > div").attr("id");
  $(".year_row").hide();
  $(selector).each(function() {
    $(this).show("fast");
  });
});