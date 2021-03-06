$(function () {
    $(document).on("click", ".btn_cart", function () {
        var _this = $(this);
        var it_id = $(this).data("it_id");
        if (!$(this).hasClass('added')) {
            var $opt = $(this).closest("li.sct_li").find(".sct_cartop");
            var $btn = $(this).closest("li.sct_li").find(".sct_btn");

            $(".sct_cartop").not($opt).css("display", "");

            $.ajax({
                url: g5_theme_shop_url + "/ajax.itemoption.php",
                type: "POST",
                data: {
                    "it_id": it_id
                },
                dataType: "json",
                async: true,
                cache: false,
                success: function (data, textStatus) {
                    if (data.error != "") {
                        alert(data.error);
                        return false;
                    }

                    $opt.html(data.html);

                    if (!data.option) {
                        add_cart_noop($opt.find("form").get(0));
                        _this.addClass('added');
                        return;
                    }

                    $opt.css("display", "block");
                }
            });
            return;
        }
            $.ajax({
                url: g5_theme_shop_url + '/ajax.cart.minus.php',
                type: "POST",
                data: {
                    'del': 1,
                    'it_id': it_id
                },
                dataType: "json",
                async: true,
                cache: false,
                success: function (data, textStatus) {
                    _this.removeClass('added');
                    $('.s_cart').load(document.URL + ' .s_cart');
                }
            });
    });

    $(document).on("change", "select.it_option", function () {
        var $frm = $(this).closest("form");
        var $sel = $frm.find("select.it_option");
        var sel_count = $sel.size();
        var idx = $sel.index($(this));
        var val = $(this).val();
        var it_id = $frm.find("input[name='it_id[]']").val();

        // ???????????? ?????? ?????? ?????? ????????? disabled
        if (val == "") {
            $frm.find("select.it_option:gt(" + idx + ")").val("").attr("disabled", true);
            return;
        }

        // ????????????????????????
        if (sel_count > 1 && (idx + 1) < sel_count) {
            var opt_id = "";

            // ?????? ????????? ?????? ?????? ??????id ??????
            if (idx > 0) {
                $frm.find("select.it_option:lt(" + idx + ")").each(function () {
                    if (!opt_id)
                        opt_id = $(this).val();
                    else
                        opt_id += chr(30) + $(this).val();
                });

                opt_id += chr(30) + val;
            } else if (idx == 0) {
                opt_id = val;
            }

            $.post(
                g5_shop_url + "/itemoption.php",
                { it_id: it_id, opt_id: opt_id, idx: idx, sel_count: sel_count },
                function (data) {
                    $sel.eq(idx + 1).empty().html(data).attr("disabled", false);

                    // select??? ????????? ???????????? ?????? ?????? ?????? disabled
                    if (idx + 1 < sel_count) {
                        var idx2 = idx + 1;
                        $frm.find("select.it_option:gt(" + idx2 + ")").val("").attr("disabled", true);
                    }
                }
            );
        } else if ((idx + 1) == sel_count) { // ??????????????????
            if (val == "")
                return;

            var info = val.split(",");
            // ????????????
            if (parseInt(info[2]) < 1) {
                alert("???????????? ????????????????????? ????????? ???????????? ????????? ??? ????????????.");
                return false;
            }
        }
    });

    $(document).on("click", ".cartopt_cart_btn", function () {
        add_cart(this.form);
    });

    $(document).on("click", ".cartopt_close_btn", function () {
        $(this).closest("li.sct_li").find(".sct_cartop").css("display", "none");
        $(this).closest("li.sct_li").find(".sct_btn").css("display", "");
    });

    $(document).on("click", ".cartop_bg", function () {
        $(this).closest(".sct_cartop").css("display", "none");
    });



    $(document).on("click", ".btn_wish", function () {
        add_wishitem(this);
    });
});

function add_wishitem(el) {
    var $el = $(el);
    var it_id = $el.data("it_id");

    if (!it_id) {
        alert("??????????????? ???????????? ????????????.");
        return false;
    }

    $.post(
        g5_theme_shop_url + "/ajax.wishupdate.php",
        { it_id: it_id },
        function (error) {
            if (error != "OK") {
                alert(error.replace(/\\n/g, "\n"));
                return false;
            }

            alert("????????? ?????????????????? ???????????????.");
            return;
        }
    );
}

function add_cart(frm) {
    var $frm = $(frm);
    var $sel = $frm.find("select.it_option");
    var it_name = $frm.find("input[name^=it_name]").val();
    var it_price = parseInt($frm.find("input[name^=it_price]").val());
    var id = "";
    var value, info, sel_opt, item, price, stock, run_error = false;
    var option = sep = "";
    var count = $sel.size();

    if (count > 0) {
        $sel.each(function (index) {
            value = $(this).val();
            item = $(this).prev("label").text();

            if (!value) {
                run_error = true;
                return false;
            }

            // ??????????????????
            sel_opt = value.split(",")[0];

            if (id == "") {
                id = sel_opt;
            } else {
                id += chr(30) + sel_opt;
                sep = " / ";
            }

            option += sep + item + ":" + sel_opt;
        });

        if (run_error) {
            alert(it_name + "??? " + item + "???(???) ????????? ????????????.");
            return false;
        }

        price = value[1];
        stock = value[2];
    } else {
        price = 0;
        stock = $frm.find("input[name^=it_stock]").val();
        option = it_name;
    }

    // ?????? ?????? ??????
    if (it_price + parseInt(price) < 0) {
        alert("??????????????? ????????? ????????? ????????? ??? ????????????.");
        return false;
    }

    // ?????? ???????????? ??????
    $frm.find("input[name^=io_id]").val(id);
    $frm.find("input[name^=io_value]").val(option);
    $frm.find("input[name^=io_price]").val(price);

    $.ajax({
        url: frm.action,
        type: "POST",
        data: $(frm).serialize(),
        dataType: "json",
        async: true,
        cache: false,
        success: function (data, textStatus) {
            if (data.error != "") {
                alert(data.error);
                return false;
            }

            alert("????????? ??????????????? ???????????????.");
        }
    });

    return false;
}

function add_cart_noop(frm) {
    var $frm = $(frm);
    var $sel = $frm.find("select.it_option");
    var it_name = $frm.find("input[name^=it_name]").val();
    var it_price = parseInt($frm.find("input[name^=it_price]").val());
    var id = "";
    var value, info, sel_opt, item, price, stock, run_error = false;
    var option = sep = "";
    var count = $sel.size();

    if (count > 0) {
        $sel.each(function (index) {
            value = $(this).val();
            item = $(this).prev("label").text();

            if (!value) {
                run_error = true;
                return false;
            }

            // ??????????????????
            sel_opt = value.split(",")[0];

            if (id == "") {
                id = sel_opt;
            } else {
                id += chr(30) + sel_opt;
                sep = " / ";
            }

            option += sep + item + ":" + sel_opt;
        });

        if (run_error) {
            alert(it_name + "??? " + item + "???(???) ????????? ????????????.");
            return false;
        }

        price = value[1];
        stock = value[2];
    } else {
        price = 0;
        stock = $frm.find("input[name^=it_stock]").val();
        option = it_name;
    }

    // ?????? ?????? ??????
    if (it_price + parseInt(price) < 0) {
        alert("??????????????? ????????? ????????? ????????? ??? ????????????.");
        return false;
    }

    // ?????? ???????????? ??????
    $frm.find("input[name^=io_id]").val(id);
    $frm.find("input[name^=io_value]").val(option);
    $frm.find("input[name^=io_price]").val(price);

    $.ajax({
        url: frm.action,
        type: "POST",
        data: $(frm).serialize(),
        dataType: "json",
        async: true,
        cache: false,
        success: function (data, textStatus) {
            if (data.error != "") {
                alert(data.error);
                return false;
            }
            $('.s_cart').load(window.location.href + ' .s_cart');
        }
    });

    return false;
}

function cart_qty_up($it_id) {
    $.ajax({
        url: '../theme/foodholic/shop/ajax.cart.plus.php',
        type: "POST",
        data: {
            'it_id': $it_id
        },
        dataType: "json",
        async: true,
        cache: false,
        success: function (data, textStatus) {
            $('#sct_sortlst').load(document.URL + ' #sct_sortlst');
            $('.s_cart').load(document.URL + ' .s_cart');
        }
    });
}

function cart_qty_down($it_id) {
    $.ajax({
        url: '../theme/foodholic/shop/ajax.cart.minus.php',
        type: "POST",
        data: {
            'it_id': $it_id
        },
        dataType: "json",
        async: true,
        cache: false,
        success: function (data, textStatus) {
            $('#container').load(document.URL + ' #container');
            $('.s_cart').load(document.URL + ' .s_cart');
        }
    });
}

// php chr() ??????
if (typeof chr == "undefined") {
    function chr(code) {
        return String.fromCharCode(code);
    }
}