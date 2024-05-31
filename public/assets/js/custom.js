//********************************show order details ******************//
$(document).ready(function () {
    var orderDetailsPopulated = false;

    function populateOrderDetails(order) {
        var orderDetailsDiv = document.getElementById("orderDetails");
        // Clear existing order details
        orderDetailsDiv.innerHTML = "";
        order.forEach((order) => {
            orderDetailsDiv.innerHTML += `
        <p><strong>${translations.ID}</strong> ${order.id}</p>
        <p><strong>${translations.total_price}:</strong> ${order.price}</p>
        <p><strong>${translations.payment_method}:</strong> ${order.payment_method}</p>
        <p><strong>${translations.order_date}:</strong> ${order.date}</p>
        <hr>
    `;
        });
    }

    $(document).on("click", ".view-order-btn", function (e) {
        e.preventDefault();
        var buttonId = $(this).attr("id");
        var orderID = buttonId.split("-")[2];
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        var url1 = "http://semiramis.dv/orderItems/json/" + orderID;
        var url2 = "/order/show/" + orderID;

        $(".table-order-details").attr("data-url", url1);
        $(".table-order-details").bootstrapTable("refresh", { url: url1 });

        $("#orderModal").modal("show");

        var request1 = $.ajax({
            url: url1,
            type: "get",
            data: { _token: csrfToken },
        });

        var request2 = $.ajax({
            url: url2,
            type: "get",
            data: { _token: csrfToken },
        });

        Promise.all([request1, request2])
            .then(function (results) {
                var data1 = results[0];
                var data2 = results[1];
                console.log("Data from request1:", data1);
                console.log("Data from request2:", data2);

                if (data2.order) {
                    populateOrderDetails(data2.order);
                    orderDetailsPopulated = true;
                }
            })
            .catch(function (error) {
                console.error("Error occurred:", error);
            });
    });

    $(document).on("click", ".close", function (e) {
        e.preventDefault();
        $("#orderModal").modal("hide");
    });

    $("#orderModal").on("shown.bs.modal", function () {});
});

//********************************show order details ******************//

//************************************order date formatting************************************************//
document.addEventListener("DOMContentLoaded", function () {
    function getCurrentDate() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, "0");
        const day = String(now.getDate()).padStart(2, "0");
        return `${year}-${month}-${day}`;
    }
    const orderDateInput = document.getElementById("order_date");
    orderDateInput.value = getCurrentDate();
});
//************************************order date formatting************************************************//

//**********************************************date range picker************************************************//
$(document).ready(function () {
    var start = moment().subtract(29, "days");
    var end = moment();

    function cb(start, end) {
        $("#reportrange span").html(
            start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
        );
    }

    $("#reportrange").daterangepicker(
        {
            startDate: start,
            endDate: end,
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [
                    moment().subtract(1, "days"),
                    moment().subtract(1, "days"),
                ],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [
                    moment().startOf("month"),
                    moment().endOf("month"),
                ],
                "Last Month": [
                    moment().subtract(1, "month").startOf("month"),
                    moment().subtract(1, "month").endOf("month"),
                ],
            },
        },
        cb
    );

    cb(start, end);
});

//**********************************************date range picker************************************************//
var countOfSuccessSales = $(".countOfSuccessSales");
var countOfPriceSales = $(".countOfPriceSales");
$(document).ready(function () {
    if (window.location.pathname === "/") {
        $("#reportrange").on("apply.daterangepicker", (e, picker) => {
            $("#spinner").addClass("activate");
            var selectedRange = $("#reportrange").text();
            var [startDateText, endDateText] = selectedRange.split("-");
            var startDateFormatted = new Date(startDateText)
                .toLocaleDateString("en-US", {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                })
                .split("/")
                .reverse()
                .join("-")
                .replace(/^(\d{4})-(\d{2})-(\d{2})$/, "$1-$3-$2");
            var endDateFormatted = new Date(endDateText)
                .toLocaleDateString("en-US", {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                })
                .split("/")
                .reverse()
                .join("-")
                .replace(/^(\d{4})-(\d{2})-(\d{2})$/, "$1-$3-$2");
            var companyId = $("#company_id").val();
            var branchId = $("#branch_id").val();

            if (companyId !== "" && companyId !== null) {
                fetchData(
                    "/get-count-of-company-sales-daterange/" + companyId,
                    startDateFormatted,
                    endDateFormatted
                );
                fetchProductsNumber(
                    "/get-count-of-company-products-daterange/" + companyId,
                    startDateFormatted,
                    endDateFormatted
                );
            } else if (branchId !== "" && branchId !== null) {
                fetchData(
                    "/get-count-of-branch-sales-daterange/" + branchId,
                    startDateFormatted,
                    endDateFormatted
                );
                fetchProductsNumber(
                    "/get-count-of-branch-products-daterange/" + branchId,
                    startDateFormatted,
                    endDateFormatted
                );
            } else {
                fetchData(
                    "/get-count-of-sales-daterange-AllCompanies",
                    startDateFormatted,
                    endDateFormatted
                );
                fetchProductsNumber(
                    "/get-count-of-products-daterange-AllCompanies",
                    startDateFormatted,
                    endDateFormatted
                );
            }
        });

        function fetchData(url, startDate, endDate) {
            $.ajax({
                url: url,
                type: "get",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    console.log(data);
                    countOfSuccessSales.text(data.ordersCountDaterange);
                    countOfPriceSales.text(
                        data.ordersSalesDaterange +
                            " " +
                            (data.currencySymbol ? data.currencySymbol : "")
                    );
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    countOfSuccessSales.text(0);
                    countOfPriceSales.text(0);
                },
                complete: function () {
                    $("#spinner").removeClass("activate");
                },
            });
        }
        function fetchProductsNumber(url, startDate, endDate) {
            var numOfProducts = $(".numOfProducts");
            $.ajax({
                url: url,
                type: "get",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    numOfProducts.text(data.numOfProducts);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        }
    }
});

//*********************************************AJAX request to count of sales and products related to a branch********************************//
$(document).ready(function () {
    var numOfProducts = $(".numOfProducts");
    if (window.location.pathname === "/") {
        $("#branch_id").change(function () {
            $("#spinner").addClass("activate");
            var branchId = $(this).val();
            $.ajax({
                url: "/get-numOfProducts-for-a-branch/" + branchId,
                type: "GET",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    numOfProducts.text(data.numOfProducts);
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching num of products:", error);
                },
            });
            $.ajax({
                url: "/get-count-of-sales-for-a-branch/" + branchId,
                type: "get",
                data: { _token: $('meta[name="csrf-token"]').attr("content") },
                success: function (data) {
                    countOfSuccessSales.text(data.ordersBranchCount);
                    countOfPriceSales.text(
                        data.ordersBranchSales +
                            " " +
                            (data.currencySymbol ? data.currencySymbol : "")
                    );
                },
                error: function (xhr, status, error) {
                    console.log(error);
                },
                complete: function () {
                    $("#spinner").removeClass("activate");
                },
            });
        });
    }
});

//*********************************************AJAX request to get branches of the selected branch and count of sales related to a branch********************************//

/******************************first page downloaded get the info for all statistics*********************** */
var numOfProducts = $(".numOfProducts");
function fetchNumOfProductsForAllCompanies() {
    $.ajax({
        url: "/get-numOfProducts-for-all-companies",
        type: "GET",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            numOfProducts.text(data.numOfProducts);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching num of products:", error);
        },
    });
}

function fetchCountOfSales() {
    $.ajax({
        url: "/get-count-of-sales",
        type: "GET",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            countOfSuccessSales.text(data.orderCount);
            countOfPriceSales.text(data.orderSales);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching count of sales:", error);
        },
        complete: function () {
            $("#spinner").removeClass("activate");
        },
    });
}
if (window.location.pathname === "/") {
    $(document).ready(function () {
        fetchNumOfProductsForAllCompanies();
        fetchCountOfSales();
        $("#spinner").addClass("activate");
    });
}

/******************************first page downloaded get the info for all statistics************************/
/*************************************get all branches to invoke it twice */
function getBranches() {
    var branchSelect = $("#branch_id");
    $.ajax({
        url: "/get-branches",
        type: "GET",
        data: { _token: $('meta[name="csrf-token"]').attr("content") },
        success: function (data) {
            branchSelect.empty();
            var selectBranch = translations.select_branch;
            branchSelect.append(
                `<option selected disabled value="">${selectBranch}</option>`
            );
            $.each(data, function (key, value) {
                branchSelect.append(
                    '<option value="' +
                        value.id +
                        '">' +
                        value.name +
                        "</option>"
                );
            });
            $("#branch_select_wrapper").show();
        },
        error: function (xhr, status, error) {
            console.error("Error fetching branches:", error);
            branchSelect.append(
                '<option value="" disabled>Error loading branches</option>'
            );
            $("#branch_select_wrapper").show();
        },
        complete: function () {
            $("#spinner").removeClass("activate");
        },
    });
}

/*************************************get all branches to invoke it twice */
/***********************sales based on different filtering factories********************/
$(document).ready(function () {
    var numOfProducts = $(".numOfProducts");

    function fetchBranchesAndSales(companyId) {
        $("#spinner").addClass("activate");
        var branchSelect = $("#branch_id");
        var productSelect = $("#product_id");
        var noBranches = translations.no_branches;
        branchSelect.empty();
        productSelect.empty();
        if (companyId !== "") {
            $.when(
                $.ajax({
                    url: "/get-branches/" + companyId,
                    type: "GET",
                    success: function (data) {
                        var selectBranch = translations.select_branch;
                        if (data.length > 0) {
                            branchSelect.append(
                                `<option selected disabled value="">${selectBranch}</option>`
                            );
                            $.each(data, function (key, value) {
                                branchSelect.append(
                                    '<option value="' +
                                        value.id +
                                        '">' +
                                        value.name +
                                        "</option>"
                                );
                            });
                            $("#branch_select_wrapper").show();
                        } else {
                            branchSelect.append(
                                `<option  disabled value="">${selectBranch}</option>`
                            );
                            branchSelect.append(
                                `<option disabled value="">${noBranches}</option>`
                            );
                            $("#branch_select_wrapper").show();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching branches:", error);
                    },
                }),
                window.location.pathname === "/orders/create"
                    ? $.ajax({
                          url: "/get-products/" + companyId,
                          type: "GET",
                          success: function (data) {
                              console.log(data.productIds);
                              if (
                                  data.productIds.length > 0 &&
                                  data.productNames.length > 0
                              ) {
                                  productSelect.empty();

                                  // Iterating over productIds and productNames arrays simultaneously
                                  for (
                                      var i = 0;
                                      i < data.productIds.length;
                                      i++
                                  ) {
                                      productSelect.append(
                                          '<option value="' +
                                              data.productIds[i] +
                                              '">' +
                                              data.productNames[i] +
                                              "</option>"
                                      );
                                  }
                                  $("#branch_select_wrapper").show();
                              } else {
                                  $("#branch_select_wrapper").show();
                                  branchSelect.append(
                                      `<option disabled value="">${noBranches}</option>`
                                  );
                                  var noProducts = translations.no_products;
                                  productSelect.append(
                                      `<option value="">${noProducts}</option>`
                                  );
                              }
                          },
                          error: function (xhr, status, error) {
                              console.error("Error fetching products:", error);
                          },
                      })
                    : null,
                $.ajax({
                    url: "/get-count-of-branch-sales/" + companyId,
                    type: "GET",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (data) {
                        countOfSuccessSales.text(data.ordersBranchCount);
                        countOfPriceSales.text(
                            data.ordersBranchSales +
                                " " +
                                (data.currencySymbol ? data.currencySymbol : "")
                        );
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching branch sales:", error);
                    },
                })
            ).always(function () {
                $("#spinner").removeClass("activate");
            });
        } else {
            getBranches();
            fetchCountOfSales();
            fetchNumOfProductsForAllCompanies();
        }
    }

    function fetchNumOfProduct(companyId) {
        if (companyId !== "") {
            $.ajax({
                url: "/get-numOfProducts-for-a-company/" + companyId,
                type: "GET",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    numOfProducts.text(data.numOfProducts);
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching num of products:", error);
                },
            });
        } else {
            $.ajax({
                url: "/get-numOfProducts-for-all-companies",
                type: "GET",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    numOfProducts.text(data.numOfProducts);
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching num of products:", error);
                },
            });
        }
    }

    if (
        window.location.pathname === "/" ||
        window.location.pathname === "/orders/create"
    ) {
        $("#company_id").change(function () {
            var companyId = $(this).val();
            fetchBranchesAndSales(companyId);
            fetchNumOfProduct(companyId);
        });
        $(document).ready(function () {
            $("#branch_id").change(function () {
                $("#spinner").addClass("activate");
                var branchId = $(this).val();
                var productContainer = $("#product_container");
                var productSelect = $("#product_id");

                if (branchId) {
                    productContainer.show();
                    productSelect.show();
                    $.ajax({
                        url: "/get-branch-products/" + branchId,
                        type: "GET",
                        success: function (data) {
                            console.log(
                                "Product Branch IDs:",
                                data.productBranchIds
                            );
                            console.log(
                                "Product Branch Names:",
                                data.productBranchNames
                            );
                            if (
                                data.productBranchIds.length > 0 &&
                                data.productBranchNames.length > 0
                            ) {
                                productSelect.empty();
                                // Iterating over productIds and productNames arrays simultaneously
                                for (
                                    var i = 0;
                                    i < data.productBranchIds.length;
                                    i++
                                ) {
                                    productSelect.append(
                                        '<option value="' +
                                            data.productBranchIds[i] +
                                            '">' +
                                            data.productBranchNames[i] +
                                            "</option>"
                                    );
                                }
                                $("#branch_select_wrapper").show();
                            } else {
                                productSelect.empty();
                                var noProducts = translations.no_products;
                                productSelect.append(
                                    `<option value="">${noProducts}</option>`
                                );
                            }
                        },
                        error: function (xhr, status, error) {
                            productSelect.empty();
                            var noProducts = translations.no_products;
                            productSelect.append(
                                `<option value="">${noProducts}</option>`
                            );
                            console.error("Error fetching products:", error);
                        },
                        complete: function () {
                            $("#spinner").removeClass("activate");
                        },
                    });
                } else {
                    // Hide the product container and select if no branch is selected
                    productContainer.hide();
                    productSelect.hide();
                }
            });
        });
    }

    // Fetch initial count of sales on page load
    fetchCountOfSales();
});

/***********************sales based on different filtering factories********************/

//*********************************************dashboard area********************************//

/******************************************stock details*******************************************************/
if (window.location.pathname === "/stocks/details") {
    getAllProducts();

    $("#company_id").change(function () {
        $("#spinner").addClass("activate");
        var companyId = $(this).val();
        var branchSelect = $("#branch_id");
        var selectBranch = translations.select_branch;
        var noBranches = translations.no_branches;
        if (companyId !== "") {
            $.ajax({
                url: "/get-branches/" + companyId,
                type: "GET",
                success: function (data) {
                    branchSelect.empty();
                    if (data.length > 0) {
                        branchSelect.append(
                            `<option value="">${selectBranch}</option>`
                        );
                        $.each(data, function (key, value) {
                            branchSelect.append(
                                '<option value="' +
                                    value.id +
                                    '">' +
                                    value.name +
                                    "</option>"
                            );
                        });
                    } else {
                        branchSelect.append(
                            `<option value="">${selectBranch}</option>`
                        );
                        branchSelect.append(
                            `<option disabled value="">${noBranches}</option>`
                        );
                    }
                    $("#branch_select_wrapper").show();
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching branches:", error);
                },
            });
            $.ajax({
                url: "/get-products-for-a-company/" + companyId,
                type: "get",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    renderProducts(data.products);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                },
                complete: function () {
                    $("#spinner").removeClass("activate");
                },
            });
        } else {
            getBranches();
            getAllProducts();
        }
    });

    $("#branch_id").change(function () {
        $("#spinner").addClass("activate");
        var branchId = $(this).val();

        console.log("Branch ID selected: " + branchId);

        if (branchId !== "") {
            $.ajax({
                url: "/get-products-for-a-branch/" + branchId,
                type: "get",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    $(".card-container").empty();
                    if (data.products && data.products.length > 0) {
                        renderProducts(data.products);
                    } else {
                        var noProductsMessage = $(
                            '<div class="no-products-message">'
                        ).html("<h2>No products found</h2>");
                        $(".card-container").append(noProductsMessage);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching products for branch:", error);
                },
                complete: function () {
                    $("#spinner").removeClass("activate");
                },
            });
        } else {
            $(".card-container").empty();
            var noProductsMessage = $('<div class="no-products-message">').html(
                "<h2>No branch selected</h2>"
            );
            $(".card-container").append(noProductsMessage);
            $("#spinner").removeClass("activate");
        }
    });

    function getAllProducts() {
        $.ajax({
            url: "/get-all-companies-products",
            type: "get",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                renderProducts(data.products);
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
            complete: function () {
                $("#spinner").removeClass("activate");
            },
        });
    }

    function renderProducts(products) {
        $(".card-container").empty();
        if (products && products.length > 0) {
            products.forEach(function (product, index) {
                var card = $('<div class="card">');
                var cardHeader = $(
                    '<div class="card-header" style="text-align: center; color:#b66dff">'
                ).text(index + 1);
                var cardBody = $('<div class="card-body">');
                var cardTitle = $(
                    '<h5 class="card-title category-title" style="text-align:center;">'
                ).text(product.name);
                var imageUrl = "http://semiramis.dv/uploads/" + product.image;
                var cardText = $(
                    '<img src="' +
                        imageUrl +
                        '" style="display: block; width:180px; height:180px" class="card-text">'
                );
                var goToProduct = translations.go_to_product;
                var cardLink = $(
                    `<a href="product/${product.id}" class="btn btn-primary" style="margin-top:10px;">`
                ).text(goToProduct);
                cardBody.append(cardTitle, cardText, cardLink);
                card.append(cardHeader, cardBody);
                $(".card-container").append(card);
            });
        } else {
            var noProductsMessage = $('<div class="no-products-message">').html(
                "<h2>No products found</h2>"
            );
            $(".card-container").append(noProductsMessage);
        }
    }
}

/******************************************stock details*******************************************************/

//*********************************************select area********************************//
$(document).ready(function () {
    //********************************single select function*****************************
    $(".single-select").change(function () {
        var select = $(this);
        var quantityFieldsContainer = $("#quantity_fields");
        quantityFieldsContainer.empty();

        var quantityLabel = translations.quantity_for;

        var id = select.val();

        var name = select.find("option:selected").text();

        var quantityField = `
            <div class="form-group ">
                <label for="quantity_${id}">${quantityLabel} ${name}</label>
                <input type="number" name="stock_quantity" class="form-control " id="quantity_${id}" min="1">
            </div>
        `;
        quantityFieldsContainer.append(quantityField);
    });

    //********************************single select function*****************************

    $(".multiple-select").select2();

    $(".multiple-select").change(function () {
        var productSelect = $(this);
        var quantityFieldsContainer = $("#quantity_fields");
        quantityFieldsContainer.html("");

        var quantityLabel = translations.quantity_for;

        productSelect.find("option:selected").each(function () {
            var productId = $(this).val();
            var productName = $(this).text();
            var quantityField = `
              <div class="form-group ">
                  <label for="quantity_${productId}">${quantityLabel} ${productName}</label>
                  <input type="number" name="stock_quantity[]" class="form-control " id="quantity_${productId}" min="1">
              </div>
          `;
            quantityFieldsContainer.append(quantityField);
        });
    });
});
$(document).ready(function () {
    $("#product_id").select2();

    function updateTotalOfTotalPrice() {
        var totalOfTotalSelectedPrice = 0;
        var totalOfTotalPrice = 0;

        $(".quantity_input").each(function () {
            var productId = $(this).data("product-id");
            var quantity = parseInt($(this).val()) || 0;
            var productPrice =
                parseFloat($("#product_price_" + productId).val()) || 0;
            var totalPrice = quantity * productPrice;

            totalOfTotalSelectedPrice += totalPrice;
            $("#product_total_price_" + productId).val(totalPrice.toFixed(2));
            totalOfTotalPrice += totalPrice;
        });
        $("#total_of_total_price_value").html(totalOfTotalPrice.toFixed(2));
        $("#product_total_of_total_selected_price input").val(
            totalOfTotalSelectedPrice.toFixed(2)
        );
    }

    $(document).on(
        "input",
        ".quantity_input, .product_price_input",
        function () {
            updateTotalOfTotalPrice();
        }
    );

    $("#product_id:not(.single-select)").on("change", function () {
        updateFieldsAndTotal();
    });

    $("#product_id").on("select2:unselect", function (e) {
        var deselectedProductId = e.params.data.id;
        $("#quantity_container_" + deselectedProductId).remove();
        $("#price_container_" + deselectedProductId).remove();
        $("#total_price_container_" + deselectedProductId).remove();
        updateTotalOfTotalPrice();
    });

    function updateFieldsAndTotal() {
        var productSelect = $("#product_id");
        var productIds = productSelect.val();
        var quantityFieldsContainer = $("#quantity_fields");
        var productPriceFieldsContainer = $("#product_price");
        var productTotalPriceContainer = $("#product_total_price");
        var productTotalOfTotalPriceContainer = $(
            "#product_total_of_total_price"
        );
        var productTotalOfTotalSelectedPriceContainer = $(
            "#product_total_of_total_selected_price"
        );

        quantityFieldsContainer.empty();
        productPriceFieldsContainer.empty();
        productTotalPriceContainer.empty();
        productTotalOfTotalPriceContainer.empty();

        if (productIds.length === 0) {
            return;
        }

        $.ajax({
            url: "/products-prices/" + productIds.join(","),
            type: "get",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var productPrices = response;
                var totalSelectedPrice = 0;

                productSelect.find("option:selected").each(function () {
                    var productId = $(this).val();
                    var productName = $(this).text();
                    var quantityField = `
                        <div class="form-group" id="quantity_container_${productId}">
                            <label for="quantity_${productId}">${translations.quantity_for} ${productName}</label>
                            <input type="number" name="stock_quantity[]" class="form-control quantity_input" id="quantity_${productId}" data-product-id="${productId}" min="1">
                        </div>
                    `;
                    var productPriceField = `
                        <div class="form-group" id="price_container_${productId}">
                            <label for="productPrice_${productId}">${translations.product_price_for} ${productName}</label>
                            <input type="number" name="product_price[]" value="${productPrices[productId]}" class="form-control product_price_input" id="product_price_${productId}" data-product-id="${productId}" min="1">
                        </div>
                    `;
                    var productTotalPriceField = `
                        <div class="form-group" id="total_price_container_${productId}">
                            <label for="productTotalPriceField_${productId}">${translations.product_total_price_for} ${productName}</label>
                            <input type="text" name="total_price[]" class="form-control product_total_price" id="product_total_price_${productId}" disabled>
                        </div>
                    `;

                    quantityFieldsContainer.append(quantityField);
                    productPriceFieldsContainer.append(productPriceField);
                    productTotalPriceContainer.append(productTotalPriceField);

                    totalSelectedPrice += parseFloat(productPrices[productId]);
                });
                var productTotalOfTotalPriceField = `
                <div class="form-group">
                    <label for="productTotalOfTotalPriceField">${translations.product_total_of_total_price_for}</label>
                    <div id="product_total_of_total_price">
                        <span id="total_of_total_price_value"></span>
                    </div>
                </div>
            `;
                productTotalOfTotalPriceContainer.append(
                    productTotalOfTotalPriceField
                );

                productTotalOfTotalSelectedPriceContainer.html(
                    `<input type="text" value="${totalSelectedPrice.toFixed(
                        2
                    )}" class="form-control" disabled>`
                );

                updateTotalOfTotalPrice();
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    }
});

/*select branches  for the respective company in the order section*/

$(document).ready(function () {
    /************hide the branch override the others  */
    $(document).ready(function () {
        function updateVisibility() {
            var selectedValue = $("#status > select").val();
            var statusElement = $("#status");
            var otherFormGroups = $(".form-group").not(statusElement);
            if (selectedValue === "cancelled") {
                otherFormGroups.hide();
                $("#branch_select_wrapper").css("visibility", "hidden");
            } else {
                otherFormGroups.show();
                $("#branch_select_wrapper").fadeIn();
            }
        }
        updateVisibility();
    });
    /************hide the branch override the others  */

    var url = window.location.href;
    var orderId = url.match(/\/orders\/(\d+)\/edit/);
    if (orderId) {
        orderId = orderId[1];
    }

    function populateBranches(selectedCompanyId, selectedBranchId) {
        $.ajax({
            url: "/get-branches/" + selectedCompanyId,
            type: "GET",
            success: function (data) {
                var branchSelect = $("#branch_id");
                branchSelect.empty();
                branchSelect.append(
                    $("<option>", { value: "", text: "Select Branch" })
                );
                if (data.length > 0) {
                    $.each(data, function (index, branch) {
                        branchSelect.append(
                            $("<option>", {
                                value: branch.id,
                                text: branch.name,
                                selected: branch.id == selectedBranchId,
                            })
                        );
                    });
                } else {
                    branchSelect.append(
                        $("<option>", {
                            value: "",
                            text: "No branches available",
                            disabled: true,
                        })
                    );
                }
                $("#branch_select_wrapper").show();
            },
            error: function (xhr, status, error) {
                console.error("Error fetching branches:", error);
            },
        });
    }

    function populateProducts(branchId) {
        if (branchId) {
            $.ajax({
                url: "/get-products-for-a-branch/" + branchId,
                type: "GET",
                data: { _token: $('meta[name="csrf-token"]').attr("content") },
                success: function (data) {
                    $("#branch_select_wrapper .products").remove();
                    var productSelect = $("#product_id");
                    productSelect.empty();
                    if (data.products && data.products.length > 0) {
                        $.each(data.products, function (index, product) {
                            productSelect.append(
                                $("<option>", {
                                    value: product.id,
                                    text: product.name,
                                })
                            );
                        });
                        productSelect.trigger("change");
                    } else {
                        $("#branch_select_wrapper").append(
                            $(
                                '<div class="products no-products-message">'
                            ).html("<h2>No products found</h2>")
                        );
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching products for branch:", error);
                },
                complete: function () {
                    $("#spinner").removeClass("activate");
                },
            });
        } else {
            $("#branch_select_wrapper").hide();
        }
    }

    if (orderId) {
        var selectedCompanyId = $("#company_id").val();
        var selectedBranchId = $("#branch_id").val();
        populateBranches(selectedCompanyId, selectedBranchId);
        var statusCase = translations.statusNotChangeable;
        $("#company_id").change(function () {
            var companyId = $(this).val();
            if (companyId) {
                $("#product_id").empty();
                $("#status").empty();
                $("#noStatus").text(statusCase);
                $(".selector-container").children().empty();
                populateBranches(companyId, null);
            }
        });

        $("#branch_id").change(function () {
            var branchId = $(this).val();
            $("#status").empty();
            $("#noStatus").text(statusCase);
            $("#product_id").empty();
            $(".selector-container").children().empty();
            populateProducts(branchId);
        });

        $("#status > select").change(function () {
            var selectedValue = $(this).val();
            var statusElement = $(this).closest(".form-group");
            var otherFormGroups = $(".form-group").not(statusElement);

            if (selectedValue === "cancelled") {
                otherFormGroups.hide();
            } else if (selectedValue === "success") {
                otherFormGroups.show();
                $("#branch_select_wrapper").css("visibility", "visible");
            }
        });
    }
});

/*select branches  for the respective company in the order section*/

//*********************************************select area********************************//

//********************************check orders validation*****************************
$("#formSubmitOrders").click(function (event) {
    event.preventDefault();

    document.querySelectorAll(".form-control").forEach(function (input) {
        input.classList.remove("is-invalid");
    });

    var orderDate = document.getElementById("order_date").value;
    var companyId = document.getElementById("company_id").value;
    var branchId = document.getElementById("branch_id").value;
    var status = $("#status").val();
    if (status === "") {
        status = $("#orderStatus").val();
    }
  
    
    var statusHandleCancellToSuccess = document.getElementById("orderStatus")
        ? document.getElementById("orderStatus").value
        : null;
    var productIds = Array.from(
        document.querySelectorAll("#product_id option:checked")
    ).map((option) => option.value);
    var stockQuantities = Array.from(
        document.querySelectorAll('input[name="stock_quantity[]"]')
    ).map((input) => input.value);
    var urlParts = window.location.pathname.split("/");
    var orderId = urlParts[urlParts.length - 2];
    if (!orderDate) {
        document.getElementById("order_date").classList.add("is-invalid");
        $.notify(translations.fillorderDate, {
            globalPosition: globalPosition,
        });
        return;
    }

    if (!companyId) {
        document.getElementById("company_id").classList.add("is-invalid");
        $.notify(translations.fillCompany, { globalPosition: globalPosition });
        return;
    }

    if (!branchId) {
        document.getElementById("branch_id").classList.add("is-invalid");
        $.notify(translations.fillBranch, { globalPosition: globalPosition });
        return;
    }

    if (!productIds || productIds.length === 0) {
        document.getElementById("product_id").classList.add("is-invalid");
        $.notify(translations.selectProduct, {
            globalPosition: globalPosition,
        });
        return;
    }

    var isValid = true;
    for (var i = 0; i < productIds.length; i++) {
        var productId = productIds[i];
        var quantityField = document.querySelector(
            'input[name="stock_quantity[]"][data-product-id="' +
                productId +
                '"]'
        );
        var priceField = document.querySelector(
            'input[name="product_price[]"][data-product-id="' + productId + '"]'
        );

        if (!quantityField || !priceField) {
            console.error(
                "Quantity or price field not found for product ID: " + productId
            );
            continue;
        }

        var quantity = quantityField.value;
        var price = priceField.value;

        if (
            !quantity ||
            isNaN(quantity) ||
            quantity.length > 10 ||
            parseInt(quantity) <= 0
        ) {
            quantityField.classList.add("is-invalid");
            $.notify(translations.fillQuantity, {
                globalPosition: globalPosition,
            });
            isValid = false;
            break;
        }

        if (!price || isNaN(price) || !/^\d{1,16}(\.\d{1,2})?$/.test(price)) {
            priceField.classList.add("is-invalid");
            $.notify(translations.invalidProductPrice, {
                globalPosition: globalPosition,
            });
            isValid = false;
            break;
        }

        var subtotal = quantity * price;

        if (subtotal.toString().length > 9) {
            var message = translations.subtotalExceededLimit.replace(
                "%{productNumber}",
                i + 1
            );
            $.notify(message, { globalPosition: globalPosition });
            isValid = false;
            break;
        }
    }

    if (!isValid) {
        return;
    }
    var ajaxData = {
        product_ids: productIds,
        quantities: stockQuantities,
        status: status,

        _token: $('meta[name="csrf-token"]').attr("content"),
    };

    if (Number.isInteger(parseInt(orderId))) {
        ajaxData.order_id = orderId;
    }
    if (statusHandleCancellToSuccess) {
        ajaxData.statusHandleCancellToSuccess = statusHandleCancellToSuccess;
    }

    $.ajax({
        url: "/check-stock",
        method: "POST",
        data: ajaxData,
        success: function (response) {
            $("#spinner").addClass("activate");
            document.getElementById("formDropzone").submit();
        },
        error: function (xhr) {
            if (xhr.responseJSON && xhr.responseJSON.insufficient_stock) {
                xhr.responseJSON.insufficient_stock.forEach(function (item) {
                    var productField = document.querySelector(
                        'input[name="product_id"][value="' +
                            item.product_id +
                            '"]'
                    );
                    if (productField) {
                        productField.classList.add("is-invalid");
                    }
                    $.notify(
                        item.product_name +
                            " " +
                            translations.productNotEnoughStock,
                        { globalPosition: globalPosition }
                    );
                });
            } else {
                $.notify(translations.stockCheckFailed, {
                    globalPosition: globalPosition,
                });
            }
        },
    });
});

//********************************check orders validation*****************************

//********************************check duplicateProduct and stock val function*****************************
$(document).ready(function () {
    const initialSelectedProduct = $("#product_id option:selected:first").val(); //make it const to Get the initial value on the product change to not update the value

    $("#formSubmitStock").click(function (e) {
        e.preventDefault();

        var selectedProducts = $("#product_id").val();
        var branchId = $("#branch_id").val();
        var preventSubmit = false;

        var productIds;
        if (Array.isArray(selectedProducts)) {
            productIds = selectedProducts.filter(function (productId) {
                return productId !== initialSelectedProduct;
            });
        } else {
            productIds =
                selectedProducts !== initialSelectedProduct
                    ? [selectedProducts]
                    : [];
        }

        if (productIds.length !== 0) {
            $.ajax({
                url: "/stocks/check-products-exist",
                type: "POST",
                data: {
                    productIds: productIds,
                    branchId: branchId,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (response.products.length > 0) {
                        $.each(response.products, function (index, product) {
                            if (product.exists) {
                                $.notify(
                                    translations.duplicateProduct +
                                        " " +
                                        product.name,
                                    { globalPosition: globalPosition }
                                );
                                preventSubmit = true;
                                $("#spinner").removeClass("activate");
                            }
                        });
                    }

                    // Proceed with further validation only if there are no duplicates
                    if (!preventSubmit) {
                        validateQuantitiesAndSubmit();
                    } else {
                        $("#spinner").removeClass("active");
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        } else {
            validateQuantitiesAndSubmit();
        }

        function validateQuantitiesAndSubmit() {
            var productSelect = document.getElementById("product_id");
            var selectedProducts = productSelect.selectedOptions;
            var preventSubmit = false;

            if (selectedProducts.length === 0) {
                preventSubmit = true;
                $("#product_id").addClass("is-invalid");
                $.notify(translations.selectProduct, {
                    globalPosition: globalPosition,
                });
            } else {
                for (var i = 0; i < selectedProducts.length; i++) {
                    var productId = selectedProducts[i].value;
                    var quantityInput = document.getElementById(
                        "quantity_" + productId
                    );
                    if (!quantityInput) {
                        quantityInput = document.getElementById("quantity");
                    }
                    var quantityValue = quantityInput.value.trim();

                    if (quantityValue === "") {
                        preventSubmit = true;
                        $.notify(translations.fillQuantityNumber, {
                            globalPosition: globalPosition,
                        });
                        $(quantityInput).addClass("is-invalid");
                    } else if (
                        !quantityValue.match(/^\d{1,10}$/) ||
                        parseInt(quantityValue) <= 0
                    ) {
                        preventSubmit = true;
                        $(quantityInput).addClass("is-invalid");
                        $.notify(translations.invalidQuantityFormat, {
                            globalPosition: globalPosition,
                        });
                    }
                }
            }

            if (!preventSubmit) {
                $("#spinner").removeClass("active");
                $("#stock_form").submit();
                console.log("Form submission button clicked");
            }
        }

        $('input[name="stock_quantity[]"]').on("input", function () {
            $(this).removeClass("is-invalid");
        });
    });
});

//********************************check duplicateProduct and stock val function*****************************
//***********************************************check edit stock validation*********************************************************** */

function toggleAdvancedForm() {
    var defaultForm = document.getElementById("default-edit-form");
    var advancedForm = document.getElementById("stock_form");
    var toggleButton = document.getElementById("toggleFormButton");
    if (advancedForm.style.display === "none") {
        defaultForm.style.display = "none";
        advancedForm.style.display = "block";
        toggleButton.textContent = translations.editLessDetails;
    } else {
        defaultForm.style.display = "block";
        advancedForm.style.display = "none";
        toggleButton.textContent = translations.editMoreDetails;
    }
}
$("#formSubmitStockEdit").click(function (e) {
    var preventSubmit = false;
    var quantityInput = document.getElementById("quantity");
    var quantityValue = quantityInput.value.trim();

    if (quantityValue === "") {
        preventSubmit = true;
        $.notify(translations.fillQuantityNumber, {
            globalPosition: globalPosition,
        });
        $(quantityInput).addClass("is-invalid");
    } else if (
        !quantityValue.match(/^\d{1,10}$/) ||
        parseInt(quantityValue) === 0
    ) {
        preventSubmit = true;
        $(quantityInput).addClass("is-invalid");
        $.notify(translations.invalidQuantityFormat, {
            globalPosition: globalPosition,
        });
    }

    if (preventSubmit) {
        e.preventDefault();
    }

    $('input[name="stock_quantity[]"]').on("input", function () {
        $(this).removeClass("is-invalid");
    });
});

/****************************************************check edit stock validation************************************************************** */
//********************************delete function with alertify*****************************
function destroy(type, id) {
    var itemType =
        type === "category"
            ? "categories"
            : type === "product"
            ? "products"
            : type === "orderItem"
            ? "orderItems"
            : type === "order"
            ? "orders"
            : type === "stocks"
            ? "stocks"
            : "companies";

    var itemTypeCapitalized = type.charAt(0).toUpperCase() + type.slice(1);
    var confirmationMessage =
        translations["Are you sure you want to delete this " + type + "?"];
    alertify
        .confirm()
        .setting({
            title: translations["Confirmation"],
            message: confirmationMessage,
            labels: {
                ok: translations["Yes"],
                cancel: translations["No"],
            },
            onok: function () {
                $("#spinner").addClass("activate");
                // User clicked "ok"
                $.ajax({
                    url:
                        "/" +
                        (type === "category"
                            ? "categories"
                            : type === "stock"
                            ? "stocks"
                            : type === "product"
                            ? "products"
                            : type === "orderItem"
                            ? "orderItems"
                            : type === "order"
                            ? "orders"
                            : "companies") +
                        "/" +
                        id,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        $("#spinner").addClass("activate");
                        alertify.success(
                            translations["deleting " + type + " done:"]
                        );
                        $("a.delete-button[data-" + type + '-id="' + id + '"]')
                            .closest("tr")
                            .remove();
                        $("#spinner").removeClass("activate");
                    },
                    error: function (xhr, status, error) {
                        alertify.error(translations["Deletion canceled"]);
                        $("#spinner").removeClass("activate");
                    },
                });
            },
            oncancel: function () {
                // User clicked "cancel"
                console.log(translations["Deletion canceled"]);
            },
        })
        .show();
}
//********************************delete function with alertify*****************************

//********************************dropzone area*****************************
var uploadRoute = document
    .getElementById("myDropzone")
    .getAttribute("data-upload-route");
Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("#myDropzone", {
    url: uploadRoute,
    paramName: "file",
    maxFiles: 1,
    acceptedFiles: ".jpeg, .jpg, .png, .gif",
    dictDefaultMessage: dropzoneTranslations["default_message"],
    dictFallbackMessage: dropzoneTranslations["fallback_message"],
    dictInvalidFileType: dropzoneTranslations["invalid_file_type"],
    dictFileTooBig: dropzoneTranslations["file_too_big"],
    dictResponseError: dropzoneTranslations["response_error"],
    dictCancelUpload: dropzoneTranslations["cancel_upload"],
    dictCancelUploadConfirmation:
        dropzoneTranslations["cancel_upload_confirmation"],
    dictRemoveFile: dropzoneTranslations["remove_file"],
    dictMaxFilesExceeded: dropzoneTranslations["max_files_exceeded"],
    previewTemplate: $("#dzPreviewContainer").html(),
    thumbnailWidth: 900,
    thumbnailHeight: 600,
    previewsContainer: "#previews",
    timeout: 0,

    init: function () {
        this.on("success", function (file, response) {
            if (response.success) {
                var image_name = response.image_name;
                $("#imageInput2").val(image_name);
            } else {
                console.error("Image upload failed.");
            }
        });

        this.on("error", function (file, errorMessage) {
            console.error("Error uploading file:", errorMessage);
            $.notify(errorMessage, {
                globalPosition: globalPosition,
                className: "error",
            });
            this.removeFile(file);
        });

        this.on("removedfile", function (file) {
            $("#imageInput2").val("");
        });

        this.on("uploadprogress", function (file, progress, bytesSent) {
            var progressContainer = file.previewElement.querySelector(
                ".dz-upload-container"
            );

            if (progressContainer) {
                var progressBar = progressContainer.querySelector(
                    ".dz-upload-progress"
                );
                var progressText =
                    progressContainer.querySelector(".progress-text");

                if (progressBar && progressText) {
                    progressBar.style.width = progress + "%";
                    progressText.textContent = progress + "%";
                }
            }
        });
    },

    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

//********************************dropzone area*****************************

$(document).ready(function () {
    //********************************check product validation function*****************************
    $("#formSubmitProduct").click(function (event) {
        $("#spinner").addClass("activate");
        var formFields = $(".form-control");
        formFields.removeClass("is-invalid");

        var preventSubmit = false;
        var productName = $("#exampleInputName1").val().trim();
        var productPrice = $("#productPrice").val().trim();
        var productBarcode = $("#productBarcode").val().trim();
        var productSKU = $("#productSKU").val().trim();
        var imagePath = $("#imageInput2").val();
        var priceRegex = /^\d{1,16}(\.\d{1,2})?$/;
        if (productName.length === 0 || productName.length > 35) {
            preventSubmit = true;
            $("#exampleInputName1").addClass("is-invalid");
            $.notify(translations.length_product_name, {
                globalPosition: globalPosition,
            });
        } else if (productPrice.length === 0 || productPrice.length > 16) {
            preventSubmit = true;
            $("#productPrice").addClass("is-invalid");
            $.notify(translations.length_product_price, {
                globalPosition: globalPosition,
            });
        } else if (!priceRegex.test(productPrice)) {
            preventSubmit = true;
            $("#productPrice").addClass("is-invalid");
            $.notify(translations.invalid_product_price, {
                globalPosition: globalPosition,
            });
        } else if (productSKU.length > 35) {
            preventSubmit = true;
            $("#productSKU").addClass("is-invalid");
            $.notify(translations.length_product_SKU, {
                globalPosition: globalPosition,
            });
        } else if (productBarcode.length > 35) {
            preventSubmit = true;
            $("#productBarcode").addClass("is-invalid");
            $.notify(translations.length_product_barcode, {
                globalPosition: globalPosition,
            });
        } else if (
            imagePath === "" &&
            $(".forms-sample").hasClass("imageValidation")
        ) {
            preventSubmit = true;
            $.notify(translations.image_required, {
                globalPosition: globalPosition,
            });
        }

        if (preventSubmit) {
            event.preventDefault();
            $("#spinner").removeClass("activate");
        }
    });
    //********************************check product validation function*****************************

    //********************************check validation branches function*****************************
    $("#formSubmitBranch").click(function (e) {
        $("#spinner").addClass("activate");
        e.preventDefault();
        var preventSubmit = false;
        var branchName = document
            .getElementById("exampleInputName1")
            .value.trim();
        var branchId = document.getElementById("branch_id_hidden").value;
        var companyId = document.getElementById("company_id").value;
        var imagePath = $("#imageInput2").val();
        if (branchName.length === 0) {
            preventSubmit = true;
            document
                .getElementById("exampleInputName1")
                .classList.add("is-invalid");
            $.notify(branchTranslations.fillBranchName, {
                globalPosition: globalPosition,
            });
        } else if (branchName.length > 35) {
            preventSubmit = true;
            document
                .getElementById("exampleInputName1")
                .classList.add("is-invalid");
            $.notify(branchTranslations.branchNameMax, {
                globalPosition: globalPosition,
            });
        } else if (
            imagePath === "" &&
            $(".forms-sample").hasClass("imageValidation")
        ) {
            preventSubmit = true;
            $.notify(branchTranslations.imageRequired, {
                globalPosition: globalPosition,
            });
        }
        if (!preventSubmit) {
            $.ajax({
                url: "/check-branch-unique",
                type: "POST",
                data: {
                    branch_name: branchName,
                    branch_id: branchId,
                    company_id: companyId,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (!response.unique) {
                        document
                            .getElementById("exampleInputName1")
                            .classList.add("is-invalid");
                        $.notify(branchTranslations.nonUniqueBranchName, {
                            globalPosition: globalPosition,
                        });
                        $("#spinner").removeClass("activate");
                    } else {
                        $(".forms-sample").off("submit").submit();
                    }
                },
                error: function () {
                    console.error("Error checking branch uniqueness");
                    $("#spinner").removeClass("activate");
                },
            });
        } else {
            $("#spinner").removeClass("activate");
        }

        document
            .getElementById("exampleInputName1")
            .addEventListener("input", function () {
                this.classList.remove("is-invalid");
            });
    });
    //********************************check validation branches function*****************************

    //********************************check validation categories function*****************************
    $("#formSubmitCategory").click(function (e) {
        $("#spinner").addClass("activate");
        document
            .getElementById("exampleInputName1")
            .classList.remove("is-invalid");

        var preventSubmit = false;
        var categoryName = document
            .getElementById("exampleInputName1")
            .value.trim();
        var imagePath = $("#imageInput2").val();
        if (categoryName.length === 0) {
            preventSubmit = true;
            document
                .getElementById("exampleInputName1")
                .classList.add("is-invalid");
            $.notify(translations.fillCategoryName, {
                globalPosition: globalPosition,
            });
        } else if (categoryName.length > 35) {
            preventSubmit = true;
            document
                .getElementById("exampleInputName1")
                .classList.add("is-invalid");
            $.notify(translations.categoryNameMax, {
                globalPosition: globalPosition,
            });
        } else if (
            imagePath === "" &&
            $(".forms-sample").hasClass("imageValidation")
        ) {
            preventSubmit = true;
            $.notify(translations.imageRequired, {
                globalPosition: globalPosition,
            });
        }

        if (preventSubmit) {
            e.preventDefault();
            $("#spinner").removeClass("activate");
        }

        document
            .getElementById("exampleInputName1")
            .addEventListener("input", function () {
                this.classList.remove("is-invalid");
            });
    });
    //********************************check validation categories function*****************************

    //********************************check validation companies function*****************************

    $("#formSubmitCompany").click(function (e) {
        e.preventDefault();
        $("#spinner").addClass("activate");
        $(".form-control").removeClass("is-invalid");

        var preventSubmit = false;
        var companyName = $("#exampleInputName1").val().trim();
        var companyId = $("#company_id_hidden").val();
        var imagePath = $("#imageInput2").val();

        if (companyName.length === 0) {
            preventSubmit = true;
            $("#exampleInputName1").addClass("is-invalid");
            $.notify(translations.fillCompanyName, {
                globalPosition: globalPosition,
            });
        } else if (companyName.length > 35) {
            preventSubmit = true;
            $("#exampleInputName1").addClass("is-invalid");
            $.notify(translations.companyNameMax, {
                globalPosition: globalPosition,
            });
        } else if (
            imagePath === "" &&
            $(".forms-sample").hasClass("imageValidation")
        ) {
            preventSubmit = true;
            $("#myDropzone").addClass("is-invalid");
            $.notify(translations.imageRequired, {
                globalPosition: globalPosition,
            });
        }

        if (!preventSubmit) {
            $.ajax({
                url: "/check-company-unique",
                type: "POST",
                data: {
                    company_name: companyName,
                    company_id: companyId,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (!response.unique) {
                        $("#exampleInputName1").addClass("is-invalid");
                        $.notify(translations.nonUniqueCompanyName, {
                            globalPosition: globalPosition,
                        });
                    } else {
                        $(".forms-sample").off("submit").submit();
                    }
                },
                error: function () {
                    console.error("Error checking company uniqueness");
                },
                complete: function () {
                    $("#spinner").removeClass("activate");
                },
            });
        } else {
            $("#spinner").removeClass("activate");
        }
    });

    $(".form-control").on("input", function () {
        $(this).removeClass("is-invalid");
    });

    //********************************check validation companies function*****************************
});
