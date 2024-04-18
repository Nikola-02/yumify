$(document).ready(function(){
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let timeout = null;
    function dateOfReviewFormatting(date){
        let year = date.getFullYear();
        let month = ("0" + (date.getMonth() + 1)).slice(-2); // Dodajemo 1 jer JavaScript broji mesece od 0 do 11
        let day = ("0" + date.getDate()).slice(-2);
        let hours = ("0" + date.getHours()).slice(-2);
        let minutes = ("0" + date.getMinutes()).slice(-2);
        let seconds = ("0" + date.getSeconds()).slice(-2);

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }
    function printTable(data){
        console.log(data)
        let html = ``;

        if(data.table_data.length > 0)
        {
            html+=`<table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>`;

            data.column_names.forEach(c=> {
                if (c != 'id') {
                    html += `<th scope="col">${c}</th>`
                }
            })

            if(data.table_name != 'ratings') {
                html += `<th scope="col">Edit</th>`
            }
            html += `<th scope="col">Delete</th>`

            html+=`</tr>
                    </thead>
                    <tbody>`;


            data.table_data.forEach((row, index) => {
                html+=`<tr>
                          <td>${index + 1}</td>`;

                data.column_names.forEach(c=>{
                    if(c != 'id'){
                        if(c == 'price') {
                            html += `<td>$${row[c]}</td>`;
                        }else if(c == 'image'){
                            html += `<td><img src="/storage/images/${row[c]}" alt="${row['name']}"></td>`
                        }else if(c == 'created_at' || c== 'updated_at'){
                            if(row[c]){
                                html += `<td>${dateOfReviewFormatting(new Date(row[c]))}</td>`;
                            }else{
                                html += `<td></td>`;
                            }
                        }else{
                            html += `<td>${row[c]}</td>`;
                        }
                    }
                })

                if(data.table_name != 'ratings'){
                    html+= `<td><a class="btn btn-primary d-flex justify-content-center align-items-center" href="/admin/${data.table_name}/${row['id']}/edit"><i class='bx bxs-edit'></i></a></td>`;
                }
                html+=`<td><a class="btn btn-danger d-flex justify-content-center align-items-center delete-btn" data-table="${data.table_name}" data-id="${row['id']}"><i class='bx bx-x-circle'></i></a></td>`;

                html+=`</tr>`;
            })

            html+=`</tbody>
                 </table>`

        }else{
            html = `<div class="alert alert-danger p-4">No rows for this table.</div>`;
        }

        $(".data-table").html(html);

    }

    //Print deleted row notification
    function printNotification(){
        $('.notification-admin-success-delete').removeClass('d-none');
        $('.notification-admin-success-delete').html('Successfully deleted row.');

        if(timeout){
            clearTimeout(timeout)
        }

        timeout = setTimeout(()=>{
            $('.notification-admin-success-delete').addClass('d-none');
        },3000);
    }
    async function deleteRow(id, table){

        let url = new URL(`http://localhost:8000/admin/${table}/${id}`)

        await fetch(url, {
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            }
        }).then(response => response.json())
            .then(data => {
                printTable(data)
                printNotification()
            })
            .catch(error => {
                $('.notification-admin-error').removeClass('d-none');
                $('.notification-admin-error').html('Error occurred.');

                setTimeout(()=>{
                    $('.notification-admin-error').addClass('d-none');
                },4000);
            });
    }

    $(document).on('click', '.delete-btn', function(){
        deleteRow($(this).data('id'), $(this).data('table'))
    })
})
