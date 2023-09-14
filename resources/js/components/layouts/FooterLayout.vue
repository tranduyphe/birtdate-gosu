<script>
export default {
  data() {
    return {
      image_logo_footer: '/images/logo-footer.png',
      image_qr_g: '/images/qr-g.png',
      image_qr_fb: '/images/qr-fb.png',
    };
  },
};
</script>


<template>
    <footer class="footer h-auto" style="position: unset;">
        <div class="container">
            <div class="row align-items-center main-footer position-relative">
                <div class="col-sm-3 logo-slogan-foote">
                    <div class="logo-footer">
                        <img :src="image_logo_footer" alt="" height="45">
                    </div>
                </div>
                <div class="col-sm-4 text-slogan-foote">
                    <div class="des-sl">
                        <div class="slogan-footer">
                        <div class="text-slfooter font-weight-bold"><span class="c-orange">G</span>row - <span class="c-orange">O</span>ptimize - <span class="c-orange">S</span>ynchronize - <span class="f-myriad-pro-semibold c-orange">U</span>nique</div>
                        <div class="text-slfooter font-weight-bold">Phát triển - Tối ưu - Đồng bộ - Duy nhất</div>
                        </div>
                        <div class="copyright">Crafted with <i class="mdi mdi-heart text-danger"></i> by <strong>GOSUTECH</strong></div>
                    </div>
                </div>
                <div class="col-sm-5 link-footer">
                    <div class="link-footer d-flex a-center t-center p-relative hidden-mobile" style="">
                        <a href="https://gosucorp.vn/vi/" target="_blank" class="item-link headShake mr-2">
                            <img :src="image_qr_g" alt="" class="icon-qr">
                        </a>
                        <a href="https://www.facebook.com/groups/gosu.s20" target="_blank" class="item-link headShake">
                            <img :src="image_qr_fb" alt="" class="icon-qr">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<style>
.c-orange {
    color: #ee9642 !important;
}

.logo-slogan-footer, .text-slogan-footer, .link-footer {
    z-index: 2;
}

.main-footer::after{
    background: url("/images/m-img-moon.png") no-repeat center center;
    content: "";
    width: 26vw;
    height: 30vh;
    background-size: contain;
    bottom: 0;
    right: 0;
    pointer-events: none;
    position: absolute;
}

@media only screen and (min-width: 1024px){
    .main-footer::after{
        background: url("/images/img-moon.png") no-repeat center center;
        width: 930px;
        height: 266px;
        top: -102px;
        right: -45px;
        bottom: inherit;
        position: absolute;
    }
}
</style>