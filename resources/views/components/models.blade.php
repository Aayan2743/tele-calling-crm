<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            
            </div>
            <form id="paymentForm">
            @csrf
           
            <div class="modal-body">
                Are you sure you want to select the Basic Plan for $50/month?
               
                <label for="amount">Amount (in INR):</label>
                <input type="number" id="amount1" name="amount1" value="10" required>
                <input type="number" id="plan_id" name="plan_id" value="" required>
                


                <div class="form-group">
                    <label for="paymentMethod">Choose Payment Method:</label>
                    <select class="form-select" id="paymentMethod">
                        <option value="razorpay">Razorpay</option>
                        <option value="phonepay">Phonepe</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="confirmPayment-S">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ URL::asset('build/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


$(document).ready(function(){
    $('#paymentForm').submit(function(e){
            e.preventDefault();
            let paymentMethod =$('#paymentMethod').val();
            let planAmount =$('#amount1').val();
            let planId =$('#plan_id').val();
          
           
            if (!planAmount || planAmount <= 0) {
              alert("Please enter a valid amount.");
            return;
        }

        if (paymentMethod === "razorpay") {
            initiateRazorpayPayment(planAmount,planId,paymentMethod);
        } else if (paymentMethod === "phonepay") {
            initiatePhonePePayment(planAmount);
        }
           
           
            // alert(planAmount);
          


    });

    function initiateRazorpayPayment(planAmount,planId,paymentMethod){
            
        $.ajax({
                url:"{{ route('payment.create') }}",
                type:"POST",
                data: {
                amount: planAmount,
                planId: planId,
                paymentMethod: paymentMethod,
                },
                headers: {
                    'X-CSRF-TOKEN': $('#paymentForm input[name="_token"]').val()
                },
                success: function(data) {
                    console.log('Success:', data);
                    const options = {
                            key: "rzp_test_zn3zcQle0s179F",
                            amount: planAmount * 100,
                            currency: "INR",
                            name: "Basic Plan",
                            description: "Monthly Subscription",
                            order_id: data.order_id,
                            handler: function (response) {
                                    fetch('{{ route("razorpay.callback") }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('#paymentForm input[name="_token"]').value
                                        },
                                        body: JSON.stringify({
                                            payment_id: response.razorpay_payment_id,
                                            order_id: response.razorpay_order_id,
                                            signature: response.razorpay_signature
                                        })
                                                                        // body: JSON.stringify(response)
                                    })
                                    .then(res => res.json())
                                    .then(result => {
                                     
                                        Swal.fire({
                                                icon: "success",
                                                title: "Payment Success...",
                                                text: "Payment Success....",
                                                timer: 3000,  // Time in milliseconds (3 seconds here)
                                                timerProgressBar: true,  // Optional: Show a progress bar while the timer runs
                                                willClose: () => {
                                                    // You can do something before the Swal closes
                                                    location.reload();  // Reload the page after the timer
                                                }
                                            });

                                    })
                                    .catch(err => {
                                        alert("Error processing payment: " + err.message);
                                    });
                               },
                            theme: {
                                color: "#F37254"
                            }
                     };

                const rzp = new Razorpay(options);
                rzp.open();


            },
                error: function(error) {
                         console.error('Error:', error);
                 }

        });
        
     }

     function initiatePhonePePayment(planAmount){
       
        $.ajax({
                type:"POST",
                url:"{{ route('phonepe.pay') }}",
                data: {
                     amount: planAmount
                },
                headers: {
                    'X-CSRF-TOKEN': $('#paymentForm input[name="_token"]').val()
                },
                success:function(response){
                    console.log("res"+response.paymentUrl);

                    if (response.paymentUrl) {
                    window.location.href = response.paymentUrl; // Redirect to PhonePe payment page
                } else {
                    alert('Payment initiation failed: ' + response.message);
                }
                },
                error:function(err){
                    console.log("err"+err);
                }

       });
    

    }




});






    // document.getElementById('confirmPayment').addEventListener('click', function() {
    //     var amount = document.getElementById('amount1').value;




    //     console.log(amount);
    //     var paymentMethod = document.getElementById('paymentMethod').value;

    //     if (!amount || amount <= 0) {
    //         alert("Please enter a valid amount.");
    //         return;
    //     }

    //     if (paymentMethod === "razorpay") {
    //         initiateRazorpayPayment(amount);
    //     } else if (paymentMethod === "phonepay") {
    //         initiatePhonePePayment(amount);
    //     }
    // });

    // // Razorpay Payment Function
   
    // function initiateRazorpayPayment(amount) {
    //     fetch('{{ route("payment.create") }}', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': document.querySelector('#paymentForm input[name="_token"]').value
    //         },
    //         body: JSON.stringify({ amount: amount })
    //     })
    //     .then(res => res.json())
    //     .then(data => {
    //         const options = {
    //             key: "rzp_test_zn3zcQle0s179F",
    //             amount: amount * 100,
    //             currency: "INR",
    //             name: "Basic Plan",
    //             description: "Monthly Subscription",
    //             order_id: data.order_id,
    //             handler: function (response) {
    //                 fetch('{{ route("razorpay.callback") }}', {
    //                     method: 'POST',
    //                     headers: {
    //                         'Content-Type': 'application/json',
    //                          'X-CSRF-TOKEN': document.querySelector('#paymentForm input[name="_token"]').value
    //                     },
    //                     body: JSON.stringify(response)
    //                 })
    //                 .then(res => res.json())
    //                 .then(result => {
    //                     alert("Payment successful!");
    //                     location.reload();
    //                 })
    //                 .catch(err => {
    //                     alert("Error processing payment: " + err.message);
    //                 });
    //             },
    //             theme: {
    //                 color: "#F37254"
    //             }
    //         };

    //         const rzp = new Razorpay(options);
    //         rzp.open();
    //     })
    //     .catch(err => {
    //         console.log("eeee"+ err.message);
    //         alert("Error creating order: " + err.message);
    //     });
    // }
       
      

    // // PhonePe Payment Function
    // function initiatePhonePePayment(amount) {
       
       
       
    //    $.ajax({
    //     type:"POST",
    //     url:"{{ route('phonepe.pay') }}",
    //     data:amount,
    //     success:function(res){
    //         console.log("res"+res);
    //     },
    //     error:function(err){
    //         console.log("err"+err);
    //     }

    //    });
       
       
       
       
       
       
      
    // }
</script>
