$(document).ready(function () {
  //For increment
  $(document).on("click", ".increment", function () {
    var $quantityInput = $(this).closest(".qtyBox").find(".quantityInput");
    var productId = $(this).closest(".qtyBox").find(".prodId").val();

    var currentValue = parseInt($quantityInput.val());
    if (!isNaN(currentValue)) {
      var qtyVal = currentValue + 1;
      $quantityInput.val(qtyVal);
      quantityIncDec(productId, qtyVal);
    }
  });

  //For decrement
  $(document).on("click", ".decrement", function () {
    var $quantityInput = $(this).closest(".qtyBox").find(".quantityInput");
    var productId = $(this).closest(".qtyBox").find(".prodId").val();

    var currentValue = parseInt($quantityInput.val());
    if (!isNaN(currentValue) && currentValue > 1) {
      var qtyVal = currentValue - 1;
      $quantityInput.val(qtyVal);
      quantityIncDec(productId, qtyVal);
    }
  });

  function quantityIncDec(prodId, quantityInput) {
    $.ajax({
      type: "POST",
      url: "order-code.php",
      data: {
        productIncDec: true,
        product_id: prodId,
        quantity: quantityInput,
      },
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          window.location.reload();
        }
      },
    });
  }

  //For proceed to payment
  $(document).on("click", ".proceedToPlace", function () {
    var cphone = $("#cphone").val();
    var payment_mode = $("#payment_mode").val();

    if (payment_mode == "") {
      swal("Select Payment Mode", "Select Your Payment Mode", "warning");
      return false;
    }

    if (cphone == "" && !$.isNumeric(cphone)) {
      swal("Enter Phone Number", "Enter Your Phone Number", "warning");
      return false;
    }
    var data = {
      proceedToPlace: true,
      cphone: cphone,
      payment_mode: payment_mode,
    };
    $.ajax({
      type: "POST",
      url: "order-code.php",
      data: data,
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          window.location.href = "order-summary.php";
        } else if (res.status == 404) {
          swal(res.message, res.message, res.status_type, {
            buttons: {
              catch: {
                text: "Add Customer",
                value: "catch",
              },
              cancel: "Cancel",
            },
          }).then((value) => {
            switch (value) {
              case "catch":
                $("#c_phone").val(cphone);
                $("#addCustomerModal").modal("show");
                break;

              default:
            }
          });
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  });

  //Add Customer Via Modal Box
  $(document).on("click", ".saveCustomer", function () {
    var c_name = $("#c_name").val();
    var c_phone = $("#c_phone").val();

    if (c_name != "" && c_phone != "") {
      if ($.isNumeric(c_phone)) {
        data = {
          saveCustomerBtn: true,
          name: c_name,
          phone: c_phone,
        };
        $.ajax({
          type: "POST",
          url: "order-code.php",
          data: data,
          success: function (response) {
            var res = JSON.parse(response);
            if (res.status == 200) {
              swal(res.message, res.message, res.status_type);
              $("#addCustomerModal").modal("hide");
            } else if (res.status == 422) {
              swal(res.message, res.message, res.status_type);
            } else {
              swal(res.message, rs.message, res.status_type);
            }
          },
        });
      } else {
        swal("Enter Valid Number", "", "warning");
      }
    } else {
      swal("Please Fill Require Fields!", "", "warning");
    }
  });

  //Order Save Button
  $(document).on("click", "#saveOrder", function () {
    $.ajax({
      type: "POST",
      url: "order-code.php",
      data: {
        saveOrder: true,
      },
      success: function (response) {
        console.log("Raw Response:", response);
        var res = JSON.parse(response);

        if (res.status == 200) {
          swal(res.message, res.message, res.status_type);
          $("#orderPlaceSuccessMessage").text(res.message);
          $("#orderSuccessModal").modal("show");
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  });
});
// function printMyBillingArea() {
//   var divContents = document.getElementById("myBillingArea").innerHTML;
//   var a = window.open("", "");
//   a.document.write("<html><title>POS SYSTEM</title>");
//   a.document.write('<body style="font-family: fangsong;">');
//   a.document.write(divContents);
//   a.document.write("</body></html>");
//   a.document.close();
//   a.print();
// }
