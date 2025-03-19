<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        font-size: 14px;
    }

    .foot_info .f_sns a {
        display: inline-block;
        height: 100%;
        vertical-align: top;
        background: url(https://www.innisfree.vn/static/front/vn/web/images/common/foot_sns.png) no-repeat left center / auto 100%;
    }

    .foot_info .f_sns a {
        width: 46px;
        height: 46px;
    }


    .foot_info .f_sns a.facebook {
        background-position: -59px 0;
    }

    .foot_info .f_sns a.instagram {
        background-position: -117px 0;
    }

    .foot_info .f_sns a.youtube {
        background-position: -176px 0;
    }

    .footerIn a {
        color: #fff;
    }

    a {
        color: #101010;
        text-decoration: none;
        outline: none;
    }

    .foot_info .f_sns {
        font-size: 0;
        line-height: 0;
    }

    .foot_info .f_sns a + a {
        margin-left: 12px;
    }

    #footer .footerIn {
        max-width: 1290px;
        margin: 0 auto;
        font-family: "Nunito", sans-serif;
    }

    .footerIn:after {
        content: '';
        display: block;
        clear: both;
    }

    #footer {
        padding: 25px 0 80px;
    }

    .foot_info {
        float: left;
        width: 430px;
        padding-top: 4px;
    }

    .foot_copyright {
        float: right;
        width: 20%;
    }

    ol, ul, li {
        list-style: none;
    }

    .f_util li {
        display: inline-block;
        position: relative;
        padding: 0 10px 0 15px;
    }

    .f_util li:before {
        content: '';
        display: block;
        position: absolute;
        left: 0;
        top: 50%;
        width: 1px;
        height: 14px;
        margin-top: -6px;
        background: white;
    }

</style>
<body>
<footer id="footer" style="background-color: #12b560; color: white">
    <div class="themes_active_green">
        <div class="footerIn">
            <div class="foot_info">
                <p class="f_logo"><img style="width: 200px; height: auto;"
                                       src='https://www.innisfree.vn/static/front/vn/web/images/renewal/logo_ag_foot.png'>
                </p>
                <div style="margin-left: 12px;" class="f_sns">
                    <a href="https://innisfreevietnam.co/2Ab0EGA" class="facebook">facebook</a>
                    <a href="https://www.instagram.com/innisfreevietnam/?hl=vi" target="_blank" class="instagram"
                       ap-click-area="FOOTER" ap-click-name="SNS" ap-click-data="SNS_instagram">instagram</a>
                    <a href="https://innisfreevietnam.co/3eBPmud" class="youtube">youtube</a>
                    <a style="background: url(https://www.innisfree.vn/static/front/vn/web/images/common/foot_zalo.png) no-repeat left center / 100% auto;"
                       href="https://innisfreevietnam.co/3awmEtB" class="zalo"></a>
                </div>
            </div>
            <div class="foot_copyright">
                <div class="f_copy">
                    <p>ⓒ 2020 innisfree Inc. <br>All rights reserved.</p>
                </div>
            </div>
        </div>
        <div class="f_btm">
            <div class="footerIn">
                <a href="http://online.gov.vn/Home/WebDetails/54900?AspxAutoDetectCookieSupport=1" target="_blank"
                   class="ico_biz" style="float: right;  "><img style="width:151px; height:56px;"
                                                                src="https://www.innisfree.vn/static/front/vn/web/images/common/ico_foot_biz.png"
                                                                alt=""></a>
                <ul class="f_util">
                    <li><a href="<?= WEBROOT ?>policy/giaohang" ap-click-area="FOOTER" ap-click-name="utility"
                           ap-click-data="terms_of_service">Delivery & Payment Policy</a></li>
                    <li><a href="<?= WEBROOT ?>policy/muahang" ap-click-area="FOOTER" ap-click-name="utility"
                           ap-click-data="privacy_policy">Privacy Policy</a></li>
                    <li><a href="<?= WEBROOT ?>policy/muahang" ap-click-area="FOOTER" ap-click-name="utility"
                           ap-click-data="purchase_policy">Purchase Policy</a></li>
                    <li><a href="<?= WEBROOT ?>policy/trahang" ap-click-area="FOOTER" ap-click-name="utility"
                           ap-click-data="return_policy">Return Policy</a></li>
                </ul>
                <div class="f_cs">
                    <ul>
                        <li>Business hours <span>Mon ~ Fri 09:00 ~ 17:00 (except Sat, Sun and holidays)</span>
                        </li>
                        <li>Customer support <span><a
                                        href="tel:02838279777">028 3827 9777 (Ext: 125)</a></span></li>
                        <li>Email <span><a href="mailto:cs_vn@innisfree.com">cs_vn@innisfree.com</a></span></li>
                    </ul>
                </div>
                <div class="f_biz">
                    <ul>
                        <li>CÔNG TY TNHH AMOREPACIFIC VIỆT NAM</li>
                        <li>Business registration: 0309984165 - Issued 05/05/2010, amended 21st time on 04/04/2022</li>
                        <li>Issuing authority: Ho Chi Minh City Department of Planning and Investment - Business Registration Office</li>
                        <li>Registered address: 4A Floor, Vincom Building, 72 Le Thanh Ton, Ben Nghe Ward, District 1, Ho Chi Minh City, Vietnam</li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>