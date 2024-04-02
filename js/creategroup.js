$( document ).ready(function() {
    $( "#major-select" ).on( "change", function() {
        var selected = $('#major-select').val();
        switch(selected) {
          case 'Advanced Business Technologies':
            $('#countstudent').text(20)
            $('#number_students').val(20);
            break;
          case 'Business Web and Mobile Technologies':
           $('#countstudent').text(25)
           $('#number_students').val(25);
          case 'Fundamentals of programming':
            $('#countstudent').text(24)
            $('#number_students').val(24);
          case 'Unix and C Programming':
            $('#countstudent').text(25)
            $('#number_students').val(25);
            break;
          case 'Unix System Programming':
            $('#countstudent').text(21);
            $('#number_students').val(21);
            break;
          case 'Enterprise Architecture':
            $('#countstudent').text(26);
            $('#number_students').val(26);
            break; 
        case 'Project Management':
            $('#countstudent').text(30);
            $('#number_students').val(30);
            break;
        case 'Engineering Management':
             $('#countstudent').text(24);
             $('#number_students').val(24);
            break;                 
          default:
            // code block
        }
} );

});