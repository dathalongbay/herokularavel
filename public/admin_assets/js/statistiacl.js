 $(document).ready(function(){
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
    $('#year').change(function() {
        year = $(this).val();
        getDataLine(year)

    });
    function getDataLine(year)
    {
        $.ajax({
            url: 'admin/getdata-line/'+year,
            method: 'get',
            success:function(rp) {
                console.log(rp)
                new Chart(document.getElementById("lineChart"), {
                    type: 'line',
                    data: {
                        labels: [1,2,3,4,5,6,7,8,9,10,11,12],
                        datasets: [
                            {
                                data: [rp[1],rp[2],rp[3],rp[4],rp[5],rp[6],rp[7],rp[8],rp[9],rp[10],rp[11],rp[12],],
                                borderColor: "#3e95cd",
                                fill: false
                            },
                        ]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Biểu đồ thống kê số tiền bán được trong năm '+year,
                        }
                    }
                });
            }
        })
    }
    getDataLine($('#year').val());
 })
