<html>
    <head>
        <title>Departments</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
        <table border="1px" id="userTable">
            <thead>
                <tr>
                    <th>Διεύθυνση</th>
                    <th>Αναγνωριστικό</th>
                    <th>Τμήματα</th>
                    <th>Κατηγορίες</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <script>
            $(document).ready(function(){
                $.ajax({
                    url:'<herokulink>',
                    type: 'get',
                    dataType: 'JSON'
                })
                .done(function(response){
                    console.log(response);
                    var len = response.length;
                    for (var i=0; i<len; i++){
                        var name = response[i].name;
                        var identifier = response[i].identifier;

                        var subdepartment = [];
                        $.each(response[i].subdepartment, function(index, value){
                            subdepartment.push(value.name);
                        });

                        subdepartment = subdepartment.join(", ");

                        var tr_str = "<tr>" + 
                            "<td>" + name + "</td>" +
                            "<td>" + identifier + "</td>" +
                            "<td>" + subdepartment + "</td>" +
                            "</tr>";

                        $("#userTable tbody").append(tr_str);
                    }
                });
            });
        </script>
    </body>
</html>