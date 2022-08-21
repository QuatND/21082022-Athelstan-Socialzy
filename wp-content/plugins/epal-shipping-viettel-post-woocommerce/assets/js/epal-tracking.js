jQuery(document).ready(function($) {
    genCapcha = function() {
        document.getElementById("idCaptcha").value = "";
        document.getElementById("txtCaptcha").value = "";
        fetch('https://api.viettelpost.vn/api/orders/getCaptcha')
            .then(response => response.json())
            .then(res => {
                if (res && res.data) {
                    document.getElementById("imgCaptcha").setAttribute("src", res.data.captcha);
                    document.getElementById("idCaptcha").value = res.data.id;
                }
            });
    }

    trackOrder = function() {
        if (!document.getElementById("txtSearch").value) {
            alert("Vui lòng nhập mã phiếu gửi!");
            return;
        }

        if (!document.getElementById("txtCaptcha").value) {
            alert("Vui lòng nhập capcha!");
            return;
        }
        const data = {
            "orders": document.getElementById("txtSearch").value,
            "id": document.getElementById("idCaptcha").value,
            "captcha": document.getElementById("txtCaptcha").value
        };

        document.getElementById("headerTracking").innerHTML = "";
        document.getElementById("contentTracking").innerHTML = "";
        document.getElementById("multiTracking").innerHTML = "";
        window.orders = null;
        fetch('https://api.viettelpost.vn/api/orders/viewTrackingOrders', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', },
                body: JSON.stringify(data)
            }).then(response => response.json())
            .then(res => {
                if (res && !res.error) {
                    var data = res.data;
                    console.log(data);
                    window.orders = data;
                    if (data.length == 1) {
                        genDataOneOrder(0);
                    } else {
                        genDataManyOrders(data);
                    }
                } else {
                    alert(res.message);
                }
                genCapcha();
            })
            .catch((error) => {
                genCapcha();
                alert("Hệ thống đang bận. Vui lòng thử lại sau!");
            });

    }

    genDataOneOrder = function(index) {

        var data = window.orders[index];
        var htmlHeader = '';

        // Ma phieu gui
        htmlHeader += '<div class="divbgtop">';
        htmlHeader += '<div class="divhead">';
        htmlHeader += '<span class="spantop1 colerblue">Mã phiếu gủi</span><br>';
        htmlHeader += '<span class="spantop colerblue">';
        htmlHeader += '<span>' + data.MA_KIEN + '</span></span>';
        htmlHeader += '</div>';

        // Khoi luong
        htmlHeader += '<div class="divhead">';
        htmlHeader += '<span class="spantop1 colerblue">Khối lượng(Gram)</span><br>';
        htmlHeader += '<span class="spantop colerblue">';
        htmlHeader += '<span>' + data.TRONG_LUONG + '</span></span>';
        htmlHeader += '</div>';

        // Dịch vụ
        htmlHeader += '<div class="divhead">';
        htmlHeader += '<span class="spantop1 colerblue">Dịch vụ</span><br>';
        htmlHeader += '<span class="spantop colerblue">';
        htmlHeader += '<span>' + data.DICH_VU + '</span></span>';
        htmlHeader += '</div>';

        // Trạng thái
        htmlHeader += '<div class="divhead1">';
        htmlHeader += '<span class="spantop1 colerblue">Trạng thái</span><br>';
        htmlHeader += '<span class="spantop colerblue">';
        if (data.GHI_CHU) {
            htmlHeader += '<span>' + data.GHI_CHU + '</span>';
        }
        htmlHeader += '</span>';
        htmlHeader += '</div></div>';
        htmlHeader += '<h2>THÔNG TIN TRẠNG THÁI</h2>';

        var htmlContent = '';
        var listTraking = data.TRACKINGS;
        var listInternational = data.QT_TRACKINGS;
        if (listInternational && listInternational.length > 0) {
            window.listInternational = listInternational;
            htmlContent += '<div class="div-qt">Hành trình quốc tế quý khách vui lòng theo dõi tại <a href="javascript:void(0)" onclick="openQt()">đây</a></div>'
        }
        if (listTraking && listTraking.length > 0) {
            htmlContent += '<ul style="line-height: 26px;">';
            listTraking.forEach((item, index) => {
                if (index == 0) {
                    htmlContent += '<li class="ClassLiive">';
                } else {
                    htmlContent += '<li class="ClassLiFour">';
                }
                htmlContent += '<span>' + item.ORDER_STATUSDATE + '</span>';
                htmlContent += '<span>' + item.TRA_CUU + '</span> : ';
                htmlContent += '<span>' + item.ORDER_NOTE + '</span> : ';
                htmlContent += '<span>' + item.BUU_CUC + '</span>';
                htmlContent += '</li>';
            });
            htmlContent += '</ul>';
        }

        document.getElementById("headerTracking").innerHTML = htmlHeader;
        document.getElementById("contentTracking").innerHTML = htmlContent;
    }

    genDataManyOrders = function(data) {
        var htmlContent = '';
        htmlContent += '<h2>Danh sách phiếu gửi</h2>';
        htmlContent += '<table cellpadding="4" cellspacing="0" width="100%" id="mytable">';
        htmlContent += '<tbody><tr class="tableheading">';
        htmlContent += '<th>Mã phiếu gửi</th>';
        htmlContent += '<th>Ngày gửi</th>';
        htmlContent += '<th>Bưu cục nhận</th>';
        htmlContent += '<th>Ngày trạng thái</th>';
        htmlContent += '<th>Trạng thái</th>';
        htmlContent += '<th>Trọng lượng</th></tr>';
        data.forEach((item, index) => {
            htmlContent += '<tr class="tabletext">';
            htmlContent += '<td class="tabletext"><a onclick="genDataOneOrder(' + index + ')" title="Xem chi tiết">' + item.MA_KIEN + '</a></td>';
            htmlContent += '<td class="tabletext"><span>' + item.NGAY_NHAP + '</span></td>';
            htmlContent += '<td class="tabletext"><span>' + item.BUUCUC_NHAN + '</span></td>';
            htmlContent += '<td class="tabletext"><span>' + item.TIME_TRANGTHAI + '</span></td>';
            if (item.GHI_CHU) {
                htmlContent += '<td class="tabletext"><span>' + item.GHI_CHU + '</span></td>';
            } else {
                htmlContent += '<td class="tabletext"></td>';
            }

            htmlContent += '<td class="tabletext"><span>' + item.TRONG_LUONG + '</span></td>';
        });
        htmlContent += '</tbody></table></div>';
        document.getElementById("multiTracking").innerHTML = htmlContent;
    }

    openQt = function() {
        if (window.listInternational) {
            window.listInternational.forEach(item => {
                window.open(item.TRA_CUU, '_blank');
            })
        }
    }

    genCapcha();
});