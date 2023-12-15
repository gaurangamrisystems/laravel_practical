$(document).ready(function () {
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: ticketListUrl,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'subject', name: 'subject'},
            {data: 'content', name: 'content'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });

    $(".delete_button").click(function () {
        var ticketId=$(".ticketid").val();
        $("#deleteModal").modal("hide");
        // Ajax request
        $.ajax({
            url: ticketListUrl+"/"+ticketId, // Replace with your API endpoint
            method: "delete",
            success: function (data) {
                // Handle successful response
                $("#result").html('<div class="alert alert-success">'+data.message+"</div>");
                setTimeout(function() {
                    // Code to be executed after the timeout
                    $("#result").hide(); // Hide the element with the id 'myDiv'
                    window.location.reload();
                }, 2000);
            },
            error: function (xhr, status, error) {
                // Handle errors
                if (xhr.status === 404) {
                    $("#result").html("<strong>Error:</strong> Resource not found.");
                } else if (xhr.status === 500) {
                    $("#result").html("<strong>Error:</strong> Internal Server Error.");
                } else {
                    $("#result").html("<strong>Error:</strong> " + error);
                }
            }
        });
    });
});