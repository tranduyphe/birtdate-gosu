<template>
    <div id="ThapThanhTuu-Modal">
        <!-- Nội dung modal ở đây -->
        <div class="div-img mui-ten" v-if="readInstructions == 0 && isPopupVisible" :class="{ 'd-none': clickedtabThanhTuu }">
            <div class="popup">Các Phù Thủy hãy hoàn thành nhiệm vụ tại đây để nhận nguyên liệu tham gia minigame!</div>
            <div class="img">
                <img :src="muitenimgUrl" alt="" width="120">
            </div>
        </div>
        <div class="tab-thanhtuu">
            <div class="nav flex-column nav-tabs border-0" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                <div class="nav-item mb-3">
                    <a class="nav-link" :class="{ active: readInstructions != 0 && openThuThach == 1 }"
                        @click="doneInstructions" id="v-tabs-thu-thach-tab" data-bs-toggle="tab" href="#v-tabs-thu-thach"
                        role="tab" aria-controls="v-tabs-thu-thach" aria-selected="true">Bảng<br>thử thách</a>
                </div>

                <div class="nav-item mb-3">
                    <a class="nav-link" :class="{ active: openThuThach == 0 }" id="v-tabs-ky-tich-tab" data-bs-toggle="tab"
                        href="#v-tabs-ky-tich" role="tab" aria-controls="v-tabs-ky-tich" aria-selected="false">Chậu<br>kỳ
                        tích</a>
                </div>

                <div class="nav-item mb-3">
                    <a class="nav-link" :class="{ active: openThuThach == 0 }" id="v-tabs-lich-tab" data-bs-toggle="tab"
                        href="#v-tabs-lich" role="tab" aria-controls="v-tabs-lich" aria-selected="false">Lịch<br>tưởng
                        ký</a>
                </div>

                <div class="nav-item mb-3">
                    <a class="nav-link" :class="{ active: readInstructions == 0 || openThuThach == 0 }"
                        id="v-tabs-the-le-tab" data-bs-toggle="tab" href="#v-tabs-the-le" role="tab"
                        aria-controls="v-tabs-the-le" aria-selected="false">Thể lệ</a>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12 pr-0">
                <div class="tab-content" id="v-tabs-tabContent">
                    <div class="tab-pane fade"
                        :class="{ active: readInstructions != 0 && openThuThach == 1, show: readInstructions != 0 && openThuThach == 1 }"
                        id="v-tabs-thu-thach" role="tabpanel" aria-labelledby="v-tabs-thu-thach-tab">
                        <div class="title text-center">
                            <h2 class="title-modal">Bảng thử thách</h2>
                            <img :src="lineBreak" class="mb-3">
                        </div>
                        <div class="user_code">
                            <p class="mb-0">Mã của bạn:&nbsp;</p>
                            <strong>{{ user_code }}&nbsp;</strong>
                            <button class="btn btn-success" @click="copyContent">Sao chép mã của bạn.</button>
                        </div>
                        <div class="task row justify-content-evenly align-items-center flex-column">
                            <div v-for="(item, index) in nhiemvu" :key="index"
                                class="item-task col-lg-5 d-flex align-items-center justify-content-between">
                                <div class="div-img mui-ten nhan-da"
                                    v-if="readInstructions == 0 && index == 0 && isDivVisible">
                                    <div class="popup">Bấm vào đây để nhận ĐÁ MẶT TRĂNG.</div>
                                    <div class="img">
                                        <img :src="muitenimgUrl" alt="" width="120">
                                    </div>
                                </div>
                                <span class="star" :style="{ color: item.is_reward == 0 ? '#b2ad8a' : '#289e11' }">&#10022;</span>
                                <span class="stt" :style="{ color: item.is_reward == 0 ? '#b2ad8a' : '#289e11' }">{{ index + 1 }}</span>
                                <div class="item-info col-9 d-flex align-items-center">
                                    <p class="m-0">{{ item.name }}</p>
                                    <div class="friendcode d-flex" v-if="index == 4"><input class="form-control w-75" v-model="friendCode"><button class="btn btn-success" type="button" @click="invite">Mời</button></div>
                                </div>
                                <div class="point">
                                    <p class="m-0" :style="{ color: item.is_reward == 0 ? '#b2ad8a' : '#289e11' }">{{
                                        item.current_attempts }}/{{ item.total_attempts }}</p>
                                    <button @click="GotoNhaThiDau" class="goto" v-if="index == 1 || index == 2">Đến</button>
                                    <button @click="GotoThuVien" class="goto" v-if="index == 3">Đến</button>
                                    <button class="goto" v-if="index == 8"><router-link to="wall">Đến</router-link></button>
                                </div>

                                <div class="item-button" v-if="item.is_reward == 0" :class="{'item-button-active': item.current_attempts == item.total_attempts}">
                                    <button class="btn p-0" @click="getReWard(item.type)"><img :src="iconBtn"
                                            title="Bấm vào đây để nhận thưởng"></button>
                                    <span class="diamond-reward">{{ item.diamond_reward }}</span>
                                </div>
                                <div v-else>
                                    <img :src="iconBtn" :style="{ opacity: 0.7 }" alt="" title="Đã nhận thưởng">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" :class="{ active: openThuThach == 0 }" id="v-tabs-ky-tich" role="tabpanel"
                        aria-labelledby="v-tabs-ky-tich-tab">
                        <div class="title text-center">
                            <h2 class="title-modal">Chậu kỳ tích</h2>
                            <img :src="lineBreak" class="mb-3">
                        </div>
                        <div class="task row justify-content-between">
                            <div class="img-phoenix col-5">
                                <img :src="img_chauthanhtich" alt="" width="445">
                            </div>
                            <div class="thanhtich col-7">
                                <div v-for="(item, index) in topFeathers" :key="index" class="item-task p-1">
                                    <div class="item-info text-center d-flex align-items-center justify-content-between">
                                        <div class="rank col-1">
                                            <img v-if="index + 1 == 1" :src="img_rank1" alt="" width="40">
                                            <img v-else-if="index + 1 == 2" :src="img_rank2" alt="" width="40">
                                            <img v-else-if="index + 1 == 3" :src="img_rank3" alt="" width="40">
                                            <p class="m-0" v-else>{{ index + 1 }}</p>
                                        </div>
                                        <div class="avatar">
                                            <img :src="item.avatar" width="40" height="40" style="object-fit: cover;">
                                        </div>
                                        <div class="col-5">
                                            <p class="m-0">{{ item.first_name }} {{ item.last_name }}</p>
                                        </div>
                                        <div class="attr-longvu col-2">
                                            <p class="m-0">{{ item.feathers }}</p>
                                            <img :src="iconLongvu" alt="" title="Lông Vũ" width="40">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade lich-tuong-ky" :class="{ active: openThuThach == 0 }" id="v-tabs-lich"
                        role="tabpanel" aria-labelledby="v-tabs-lich-tab">
                        <div class="title text-center">
                            <h2 class="title-modal">Lịch tưởng ký</h2>
                            <img :src="lineBreak" class="mb-3">
                        </div>

                        <div class="task row justify-content-evenly">
                            <div v-for="(item, index) in logActivity" :key="index"
                                class="item-task col-12 row justify-content-between text-center">
                                <div class="item-created-at col-2 p-2">
                                    <p class="m-0">{{ item.formatted_created_at }} </p>
                                </div>
                                <div class="item-reason col-8 p-2">
                                    <p class="m-0">{{ item.reason }}</p>
                                </div>
                                <div class="item-reason p-1 col-1 d-flex justify-content-evenly">
                                    <p v-if="item.log_item" class="m-0">{{ item.log_item[0].record ?? 0 }}</p>
                                    <img v-if="item.log_item && item.log_item[0].item_id == 1" :src="iconLongvu" alt=""
                                        width="30">
                                    <img v-if="item.log_item && item.log_item[0].item_id == 2" :src="iconKimcuong" alt=""
                                        width="30">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                        :class="{ active: readInstructions == 0 || openThuThach == 0, show: readInstructions == 0 || openThuThach == 0 }"
                        id="v-tabs-the-le" role="tabpanel" aria-labelledby="v-tabs-the-le-tab">
                        <div class="title text-center">
                            <h2 class="title-modal">Thể lệ</h2>
                            <img :src="lineBreak" class="mb-3">
                        </div>
                        <div class="content">
                            <p
                                style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 16pt;">
                                <strong><span style="font-family: Cambria; color: #2980b9;">I. Thể lệ</span></strong>
                            </p>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong><span style="font-family: Cambria;">1. Đối tượng tham gia</span></strong>
                            </p>
                            <ul type="disc" style="margin: 0pt; padding-left: 0pt;">
                                <li
                                    style="margin-top: 14pt; margin-left: 27.6pt; margin-bottom: 14pt; text-align: justify; line-height: normal; padding-left: 8.4pt; font-family: serif; font-size: 11pt;">
                                    <span style="font-family: Cambria; font-size: 14pt;">Toàn thể nhân sự chính thức và thử
                                        việc của </span><strong><span
                                            style="font-family: Cambria; font-size: 14pt; color: #e67e22;">C&ocirc;ng ty
                                            GOSU&nbsp;</span></strong>
                                </li>
                            </ul>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong><span style="font-family: Cambria;">2. Thời gian sự kiện</span></strong>
                            </p>
                            <ul type="disc" style="margin: 0pt; padding-left: 0pt;">
                                <li
                                    style="margin-top: 14pt; margin-left: 27.6pt; text-align: justify; line-height: normal; padding-left: 8.4pt; font-family: serif; font-size: 11pt;">
                                    <span style="font-family: Cambria; font-size: 14pt;">Bắt đầu: 11h11 ng&agrave;y
                                        18/09/2023.</span>
                                </li>
                                <li
                                    style="margin-left: 27.6pt; margin-bottom: 14pt; text-align: justify; line-height: normal; padding-left: 8.4pt; font-family: serif; font-size: 11pt;">
                                    <span style="font-family: Cambria; font-size: 14pt;">Kết th&uacute;c: 17h00 ng&agrave;y
                                        21/09/2023.</span>
                                </li>
                            </ul>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong><span style="font-family: Cambria;">3. C&aacute;ch thức tham gia</span></strong>
                            </p>
                            <ul type="disc" style="margin: 0pt; padding-left: 0pt;">
                                <li
                                    style="margin-top: 14pt; margin-left: 27.6pt; text-align: justify; line-height: normal; padding-left: 8.4pt; font-family: serif; font-size: 11pt;">
                                    <span style="font-family: Cambria; font-size: 14pt;">Bước 1: Đăng k&yacute; nhập học
                                        bằng c&aacute;ch v&agrave;o trang sự kiện v&agrave; đăng nhập t&agrave;i
                                        khoản&nbsp;</span>
                                    <strong><span
                                            style="font-family: Cambria; font-size: 14pt; color: #ed7d31;">GOSU</span></strong><span
                                        style="font-family: Cambria; font-size: 14pt; color: #ed7d31;">.</span>
                                </li>
                                <li
                                    style="margin-left: 27.6pt; margin-bottom: 14pt; text-align: justify; line-height: normal; padding-left: 8.4pt; font-family: serif; font-size: 11pt;">
                                    <span style="font-family: Cambria; font-size: 14pt;">Bước 2: Bắt đầu kh&aacute;m
                                        ph&aacute; c&aacute;c c&ocirc;ng tr&igrave;nh trong khu&ocirc;n vi&ecirc;n Học viện
                                        ph&aacute;p thuật&nbsp;</span>
                                    <strong><span
                                            style="font-family: Cambria; font-size: 14pt; color: #ed7d31;">GOSU</span></strong><span
                                        style="font-family: Cambria; font-size: 14pt;">&nbsp;v&agrave; ho&agrave;n
                                        th&agrave;nh c&aacute;c&nbsp;</span>
                                    <strong><span style="font-family: Cambria; font-size: 14pt;">Nhiệm vụ h&agrave;ng
                                            ng&agrave;y</span></strong><span
                                        style="font-family: Cambria; font-size: 14pt;">&nbsp;</span>
                                </li>
                            </ul>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 16pt;">
                                <strong><span style="font-family: Cambria; color: #2980b9;">II. Học viện ph&aacute;p thuật
                                        c&oacute; g&igrave;?</span></strong><strong><span
                                        style="font-family: Cambria; color: #2980b9;">&nbsp;</span></strong>
                            </p>
                            <ol type="1" style="margin: 0pt; padding-left: 0pt;">
                                <li
                                    style="margin-top: 14pt; margin-left: 34.54pt; margin-bottom: 14pt; text-align: justify; line-height: normal; padding-left: 1.46pt; font-family: Cambria; font-size: 14pt; font-weight: bold;">
                                    <span style="color: #2c3e50;">Th&aacute;p Th&agrave;nh Tựu</span>
                                </li>
                            </ol>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">L&agrave; t&ograve;a th&aacute;p m&agrave; C&aacute;c
                                    Ph&ugrave; thủy tập sự&nbsp;</span><strong><span
                                        style="font-family: Cambria; color: #ed7d31;">GOSU</span></strong>
                                <span style="font-family: Cambria;">&nbsp;thường hay gh&eacute; thăm nơi n&agrave;y
                                    v&agrave;o mỗi ng&agrave;y để điểm danh. Tại đ&acirc;y bao gồm c&aacute;c hoạt động
                                    m&agrave; Ph&ugrave; thủy tập sự cần lưu t&acirc;m như:</span>
                            </p>
                            <p
                                style="margin-top: 14pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">-</span><span
                                    style="width: 14.02pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <strong><span style="font-family: Cambria;">Bảng Thử Th&aacute;ch:</span></strong>
                                <span style="font-family: Cambria;">&nbsp;Bảng ghi ch&uacute; liệt k&ecirc; c&aacute;c hoạt
                                    động, lớp học m&agrave; Ph&ugrave; thủy tập sự cần l&agrave;m mỗi ng&agrave;y để thu
                                    thập&nbsp;</span>
                                <strong><span style="font-family: Cambria;">Đ&aacute; Mặt Trăng</span></strong><span
                                    style="font-family: Cambria;">.&nbsp;</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">-</span><span
                                    style="width: 14.02pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <strong><span style="font-family: Cambria;">Chậu Kỳ T&iacute;ch:&nbsp;</span></strong><span
                                    style="font-family: Cambria;">Chiếc vạc</span><strong><span
                                        style="font-family: Cambria;">&nbsp;</span></strong>
                                <span style="font-family: Cambria;">ti&ecirc;n đo&aacute;n bảng xếp hạng nỗ lực của
                                    c&aacute;c Ph&ugrave; thủy tập sự.</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">-</span><span
                                    style="width: 14.02pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <strong><span style="font-family: Cambria;">Lịch Tưởng K&yacute;:&nbsp;</span></strong><span
                                    style="font-family: Cambria;">Tấm lịch ghi ch&uacute; lại lịch sử hoạt động của
                                    Ph&ugrave; thủy tập sự.</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">&nbsp;</span></p>
                            <ol start="2" type="1" style="margin: 0pt; padding-left: 0pt;">
                                <li
                                    style="margin-left: 34.54pt; margin-bottom: 14pt; text-align: justify; line-height: normal; padding-left: 1.46pt; font-family: Cambria; font-size: 14pt; font-weight: bold;">
                                    <span style="color: #2c3e50;">Nh&agrave; Thi Đấu Xoẹt Xoẹt</span>
                                </li>
                            </ol>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">Tr&ograve; chơi: B&agrave;i Tr&ugrave;ng.</span></p>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">Mệnh gi&aacute;: 2 Đ&aacute; Mặt Trăng.</span></p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">Luật chơi như sau:</span></p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong><span style="font-family: Cambria;">B1:</span></strong>
                                <span style="font-family: Cambria;">&nbsp;Bảng puzzle gồm 45 &ocirc; &uacute;p mặt được sắp
                                    xếp vị tr&iacute; ngẫu nhi&ecirc;n tr&ecirc;n s&agrave;n đấu, b&ecirc;n dưới s&agrave;n
                                    đấu c&oacute; 1 thanh chờ gồm 4 &ocirc; chứa.</span>
                            </p>
                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;"><span style="font-family: Cambria;">&nbsp;</span></p>
                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong><span style="font-family: Cambria;">B2:</span></strong><span style="font-family: Cambria;">&nbsp;Mỗi một lượt, Ph&ugrave; thủy tập sự chọn 3 &ocirc; ngẫu nhi&ecirc;n. Ở lượt mở đầu tiên:</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Wingdings;"></span><span
                                    style="width: 5.19pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="font-family: Cambria;">Mở được 3 &ocirc; chứa b&oacute;ng lửa c&ugrave;ng loại
                                    -&gt; 3 &ocirc; chứa b&oacute;ng lửa sẽ biến mất.</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Wingdings;"></span><span
                                    style="width: 5.19pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="font-family: Cambria;">Kh&ocirc;ng mở được 3 &ocirc; chứa b&oacute;ng lửa
                                    c&ugrave;ng loại:</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">&nbsp;&nbsp;&nbsp;&nbsp;</span><em><span
                                        style="font-family: Cambria;">*TH 3 &ocirc; kh&aacute;c nhau: b&oacute;ng lửa của
                                        &ocirc; mở cuối c&ugrave;ng sẽ rớt xuống thanh chờ.</span></em>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <em><span style="font-family: Cambria;">&nbsp;&nbsp;&nbsp;&nbsp;</span></em>
                                <em><span style="font-family: Cambria;">*TH 2 &ocirc; giống nhau, 1 &ocirc; kh&aacute;c:
                                        b&oacute;ng lửa của &ocirc; kh&aacute;c 2 &ocirc; c&ograve;n lại sẽ rớt xuống thanh
                                        chờ.</span></em>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <em><span style="font-family: Cambria;">&nbsp;</span></em>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong><span style="font-family: Cambria;">B3:</span></strong><span
                                    style="font-family: Cambria;">&nbsp;Ph&ugrave; thủy tập sự chọn 3 &ocirc; ngẫu
                                    nhi&ecirc;n tiếp theo:</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Wingdings;"></span><span
                                    style="width: 5.19pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="font-family: Cambria;">Mở được 3 &ocirc; chứa b&oacute;ng lửa c&ugrave;ng
                                    loại&nbsp;</span>
                                <em><span style="font-family: Cambria; color: #ff0000;">(hoặc trong số c&aacute;c &ocirc;
                                        đ&atilde; mở tới giờ xuất hiện 3 b&oacute;ng lửa c&ugrave;ng
                                        m&agrave;u)&nbsp;</span></em>
                                <span style="font-family: Cambria;">-&gt; 3 &ocirc; chứa b&oacute;ng lửa sẽ biến mất.</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Wingdings;"></span><span
                                    style="width: 5.19pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="font-family: Cambria;">Cứ xuất hiện 3 b&oacute;ng lửa c&ugrave;ng loại
                                    tr&ecirc;n bảng puzzle v&agrave; thanh chờ th&igrave; 3 b&oacute;ng đ&oacute; sẽ biến
                                    mất.</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Wingdings;"></span><span
                                    style="width: 5.19pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="font-family: Cambria;">Kh&ocirc;ng mở được 3 &ocirc; chứa b&oacute;ng lửa
                                    c&ugrave;ng loại:</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">&nbsp;&nbsp;&nbsp;&nbsp;</span><em><span
                                        style="font-family: Cambria;">*TH 3 &ocirc; kh&aacute;c nhau: b&oacute;ng lửa của
                                        &ocirc; mở cuối c&ugrave;ng sẽ rớt xuống thanh chờ.</span></em>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <em><span style="font-family: Cambria;">&nbsp;&nbsp;&nbsp;&nbsp;</span></em>
                                <em><span style="font-family: Cambria;">*TH 2 &ocirc; giống nhau, 1 &ocirc; kh&aacute;c:
                                        b&oacute;ng lửa của &ocirc; kh&aacute;c 2 &ocirc; c&ograve;n lại sẽ rớt xuống thanh
                                        chờ.</span></em>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">&nbsp;</span></p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong><span style="font-family: Cambria;">B4:</span></strong><span
                                    style="font-family: Cambria;">&nbsp;Cứ tiếp tục như vậy, khi Ph&ugrave; thủy tập sự
                                    l&agrave;m biến mất to&agrave;n bộ b&oacute;ng lửa th&igrave; sẽ thắng.</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">&nbsp;</span></p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong><span style="font-family: Cambria;">B5:</span></strong><span
                                    style="font-family: Cambria;">&nbsp;Khi chiến thắng thử th&aacute;ch tại đ&acirc;y,
                                    ph&ugrave; thủy nhận được&nbsp;</span>
                                <strong><span style="font-family: Cambria;">2</span></strong><span
                                    style="font-family: Cambria;">&nbsp;</span><strong><span
                                        style="font-family: Cambria;">L&ocirc;ng Phượng Ho&agrave;ng</span></strong>
                                <span style="font-family: Cambria;">. Nếu thua sẽ kh&ocirc;ng nhận được phần thưởng.</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">&nbsp;</span></p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong>
                                    <em>
                                        <u><span style="font-family: Cambria;">Lưu &yacute;:</span></u>
                                    </em>
                                </strong>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">- Nếu thanh chờ đầy th&igrave; sẽ thua.</span></p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">- Tr&ograve; chơi kh&ocirc;ng giới hạn thời gian</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">- Mỗi lần chơi lại game sẽ random vị tr&iacute;
                                    c&aacute;c &ocirc;.</span></p>
                            <p
                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">- Thanh chờ chứa tối đa 4 &ocirc;.</span></p>
                            <ol start="3" type="1" style="margin: 0pt; padding-left: 0pt;">
                                <li
                                    style="margin-top: 14pt; margin-left: 34.54pt; margin-bottom: 14pt; text-align: justify; line-height: normal; padding-left: 1.46pt; font-family: Cambria; font-size: 14pt; font-weight: bold;">
                                    <span style="color: #2c3e50;">Thư Viện To&agrave;n Tri</span>
                                </li>
                            </ol>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">Tr&ograve; chơi: T&iacute;ch Kỳ.</span></p>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">Mệnh gi&aacute;: 5 Đ&aacute; Mặt Trăng.</span></p>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong><span style="font-family: 'Cambria'; color: #2980b9;">C&aacute;ch thức tham
                                        gia</span></strong><strong><span
                                        style="font-family: 'Cambria'; color: #2980b9;">&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top: 14pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">-</span><span
                                    style="width: 14.02pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="font-family: 'Cambria';">1 Bảng &ocirc;&nbsp;</span><span
                                    style="font-family: Cambria;">&uacute;p mặt được sắp xếp vị tr&iacute; ngẫu
                                    nhi&ecirc;n</span>
                                <span style="font-family: 'Cambria';">&nbsp;sẽ hiện ra.&nbsp;</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">-</span><span
                                    style="width: 14.02pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="font-family: 'Cambria';">Ph&ugrave; thủy chọn 1 &ocirc; bất kỳ.</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">-</span><span
                                    style="width: 14.02pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="font-family: 'Cambria';">&Ocirc; được chọn sẽ mở ra v&agrave; hiển thị vật
                                    phẩm/giải thưởng m&agrave; Ph&ugrave; thủy tập sự nhận được.</span>
                            </p>
                            <p
                                style="margin-top: 0pt; margin-left: 36pt; margin-bottom: 0pt; text-indent: -18pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">-</span><span
                                    style="width: 14.02pt; font: 7pt 'Cambria'; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="font-family: 'Cambria';">
                                    Phần thưởng c&oacute; thể bao gồm: L&ocirc;ng Phượng Ho&agrave;ng, Đ&aacute; Mặt Trăng,
                                    c&aacute;c vật phẩm qu&agrave; tặng đặc biệt từ Ban Gi&aacute;m Hiệu Học viện
                                    ph&aacute;p thuật&nbsp;
                                </span>
                                <strong><span style="font-family: 'Cambria'; color: #ed7d31;">GOSU</span></strong><span
                                    style="font-family: 'Cambria';">&nbsp;</span>
                            </p>
                            <ol start="4" type="1" style="margin: 0pt; padding-left: 0pt; padding-top: 14pt;">
                                <li
                                    style="margin-left: 34.54pt; margin-bottom: 14pt; text-align: justify; line-height: normal; padding-left: 1.46pt; font-family: Cambria; font-size: 14pt; font-weight: bold;">
                                    <span style="color: #2c3e50;">Sảnh Trường Họp Hẹp</span>
                                </li>
                            </ol>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">
                                    Đ&acirc;y l&agrave; khu vực thường được sử dụng l&agrave;m nơi tập trung của c&aacute;c
                                    ph&ugrave; thủy, tuy nhi&ecirc;n ẩn b&ecirc;n dưới nền sảnh l&agrave; 1 ấn ch&uacute;
                                    phong ấn đặc biệt m&agrave; chỉ khi c&aacute;c Ph&ugrave;
                                    thủy tập sự ho&agrave;n th&agrave;nh nhiệm vụ được giao th&igrave; ấn ch&uacute; mới
                                    được gỡ bỏ v&agrave; h&eacute; lộ điều kỳ diệu đ&atilde; bị cất giấu suốt nhiều thập kỷ
                                    tại nơi đ&acirc;y.
                                </span>
                            </p>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">Để gỡ bỏ phong ấn tại&nbsp;</span><strong><span
                                        style="font-family: Cambria;">Sảnh Trường Họp Hẹp</span></strong>
                                <span style="font-family: Cambria;">, c&aacute;c Ph&ugrave; thủy tập sự cần điểm danh 3
                                    ng&agrave;y li&ecirc;n tiếp tại&nbsp;</span><strong><span
                                        style="font-family: Cambria;">Th&aacute;p Th&agrave;nh Tựu</span></strong>
                                <span style="font-family: Cambria;">&nbsp;để g&oacute;p 1 phần ph&aacute;p lực v&agrave;o
                                    việc đảo ngược phong ấn.</span>
                            </p>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 16pt;">
                                <strong><span style="font-family: Cambria; color: #2980b9;">III. Phần thưởng</span></strong>
                            </p>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">
                                    C&oacute; chơi th&igrave; phải c&oacute; thưởng, những Ph&ugrave; thủy Tập sự xuất sắc
                                    nhất sẽ được vinh danh tại Th&aacute;p Th&agrave;nh Tựu v&agrave;o cuối kh&oacute;a học.
                                    B&ecirc;n cạnh đ&oacute;, những phần thưởng tương xứng
                                    sẽ d&agrave;nh cho những Ph&ugrave; thủy Tập sự đ&atilde; nỗ lực hết m&igrave;nh trong
                                    qu&aacute; tr&igrave;nh học tập.
                                </span>
                            </p>
                            <table cellspacing="2" cellpadding="0"
                                style="width: 468.5pt; border: 0.75pt solid #000000; border-spacing: 1.5pt;margin: auto;">
                                <tbody>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle; background-color: #2e75b5;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <strong><span style="font-family: Cambria; color: #ffffff;">Số
                                                        lượng</span></strong>
                                            </p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle; background-color: #2e75b5;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <strong><span style="font-family: Cambria; color: #ffffff;">T&ecirc;n giải</span></strong>
                                            </p>
                                        </td>
                                        <td
                                            style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle; background-color: #2e75b5;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <strong><span style="font-family: Cambria; color: #ffffff;">Điều
                                                        kiện</span></strong>
                                            </p>
                                        </td>
                                        <td
                                            style="width: 130.5pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle; background-color: #2e75b5;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <strong><span style="font-family: Cambria; color: #ffffff;">Phần
                                                        thưởng</span></strong>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <span style="font-family: Cambria;">1</span></p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Cambria;">Ph&ugrave; Thủy Huyền Thoại</span></p>
                                        </td>
                                        <td
                                            style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;">
                                                <span style="font-family: Cambria;">Ph&ugrave; thủy thu thập được nhiều
                                                    L&ocirc;ng Phượng Ho&agrave;ng 1</span></p>
                                        </td>
                                        <td
                                            style="width: 130.5pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 11pt;"><span
                                                    style="font-family: Cambria;">V&agrave;ng nhẫn SJC 1 chỉ</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <span style="font-family: Cambria;">1</span></p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Cambria;">Ph&ugrave; Thủy Quyền Năng</span></p>
                                        </td>
                                        <td
                                            style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;">
                                                <span style="font-family: Cambria;">Ph&ugrave; thủy thu thập được nhiều
                                                    L&ocirc;ng Phượng Ho&agrave;ng 2</span></p>
                                        </td>
                                        <td
                                            style="width: 130.5pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 11pt;"><span
                                                    style="font-family: Cambria;">M&agrave;n h&igrave;nh MSI PRO
                                                    MP243</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <span style="font-family: Cambria;">1</span></p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Cambria;">Ph&ugrave; Thủy Đo&agrave;n Trưởng</span></p>
                                        </td>
                                        <td
                                            style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;">
                                                <span style="font-family: Cambria;">Ph&ugrave; thủy thu thập được nhiều
                                                    L&ocirc;ng Phượng Ho&agrave;ng 3</span></p>
                                        </td>
                                        <td
                                            style="width: 130.5pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 11pt;"><span
                                                    style="font-family: Cambria;">M&aacute;y h&uacute;t bụi giường JETZT
                                                    Series J7</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <span style="font-family: Cambria;">1</span></p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Cambria;">Ph&ugrave; Thủy Bản Lĩnh</span></p>
                                        </td>
                                        <td
                                            style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;">
                                                <span style="font-family: Cambria;">Ph&ugrave; thủy tham gia thử
                                                    th&aacute;ch B&agrave;i Tr&ugrave;ng v&agrave; T&iacute;ch Kỳ nhiều
                                                    nhất</span>
                                            </p>
                                        </td>
                                        <td rowspan="5"
                                            style="width: 130.5pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 11pt;"><span
                                                    style="font-family: Cambria;">C&aacute;p sạc nhanh Baseus Bright Mirror
                                                    2 3 trong 1</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <span style="font-family: Cambria;">1</span></p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Cambria;">Ph&ugrave; Thủy Chăm Chỉ</span></p>
                                        </td>
                                        <td
                                            style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;">
                                                <span style="font-family: Cambria;">Ph&ugrave; thủy c&oacute; số lần điểm
                                                    danh nhiều nhất v&agrave; sớm nhất</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <span style="font-family: Cambria;">3</span></p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Cambria;">Ph&ugrave; Thủy Thiện Chiến</span></p>
                                        </td>
                                        <td
                                            style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;">
                                                <span style="font-family: Cambria;">Ph&ugrave; thủy chiến thắng thử
                                                    th&aacute;ch B&agrave;i Tr&ugrave;ng nhiều nhất</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <span style="font-family: Cambria;">3</span></p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Cambria;">Ph&ugrave; Thủy Ti&ecirc;n Tri</span></p>
                                        </td>
                                        <td
                                            style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;">
                                                <span style="font-family: Cambria;">Ph&ugrave; thủy thu thập được nhiều vật
                                                    phẩm nhất tại Thư Viện To&agrave;n Tri</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <span style="font-family: Cambria;">3</span></p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Cambria;">Ph&ugrave; Thủy Thần Tốc</span></p>
                                        </td>
                                        <td style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;">
                                                <span style="font-family: Cambria;">Thời gian hoàn thành 9 thử thách đầu tiên trong ngày nhanh nhất</span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 11pt;">
                                                <span style="font-family: Cambria;">189</span></p>
                                        </td>
                                        <td style="width: 113.05pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Cambria;">Ph&ugrave; Thủy Tiềm Long</span></p>
                                        </td>
                                        <td
                                            style="width: 185.25pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p
                                                style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;">
                                                <span style="font-family: Cambria;">Tham gia thử th&aacute;ch tại Thư Viện
                                                    To&agrave;n Tri sẽ c&oacute; cơ hội nhận qu&agrave;&nbsp;</span>
                                            </p>
                                        </td>
                                        <td
                                            style="width: 130.5pt; border-style: solid; border-width: 0.75pt; padding: 0.75pt; vertical-align: middle;">
                                            <p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 11pt;"><span
                                                    style="font-family: Cambria;">Thẻ Tiềm Long</span></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <strong>
                                    <em><span style="font-family: Cambria;">!! Lưu &yacute;:</span></em>
                                </strong>
                                <span style="font-family: Cambria;">&nbsp;</span><em><span style="font-family: Cambria;">Mỗi
                                        người chỉ được nhận duy nhất&nbsp;</span></em>
                                <strong>
                                    <em><span style="font-family: Cambria;">01 giải thưởng </span></em>
                                </strong>
                                <em>
                                    <span style="font-family: Cambria;">
                                        (ưu ti&ecirc;n giải c&oacute; gi&aacute; trị cao hơn, trường hợp tr&uacute;ng
                                        c&ugrave;ng l&uacute;c 2 giải, giải c&oacute; gi&aacute; trị thấp hơn sẽ được chuyển
                                        giao cho người c&oacute; thứ hạng ngay sau đ&oacute;).
                                    </span>
                                </em>
                                <em><span style="font-family: Cambria;"></span></em><em><span
                                        style="font-family: Cambria;">Thời gian trao qu&agrave; l&agrave; 30 ng&agrave;y
                                        kể</span></em><em><span style="font-family: Cambria;">&nbsp;</span></em>
                                <em><span style="font-family: Cambria;">từ l&uacute;c c&ocirc;ng bố danh s&aacute;ch
                                        tr&uacute;ng thưởng.</span></em>
                            </p>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <em><span style="font-family: Cambria;">Trường hợp người chơi c&oacute; số lượng vật phẩm
                                        bằng nhau, phần thưởng sẽ thuộc về người c&oacute; thời gian ho&agrave;n
                                        th&agrave;nh sớm hơn.</span></em>
                            </p>
                            <p
                                style="margin-top: 14pt; margin-bottom: 14pt; text-align: justify; line-height: normal; font-size: 14pt;">
                                <span style="font-family: Cambria;">&nbsp;</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    authGetters,
    authMethods,
} from "@/store/store";

export default {
    props: {
        nhiemvu: Array,
        logActivity: Array,
        topFeathers: Array,
        attrKimcuong: Number,
        attrLongvu: Number,
        user_code: String,
        readInstructions: Number,
        muitenimgUrl: String,
        openThuThach: Number,
    },
    data() {
        return {
            lineBreak: '/images/sinhnhat11nam/img_main/linebreak-title.png',
            iconBtn: '/images/sinhnhat11nam/img_main/icon-button-task.png',
            iconLongvu: '/images/sinhnhat11nam/img_main/icon-longvu.png',
            iconKimcuong: '/images/sinhnhat11nam/img_main/icon-da-mat-trang.png',
            img_chauthanhtich: '/images/sinhnhat11nam/img_main/321.png',
            img_rank1: '/images/sinhnhat11nam/img_main/rank1.png',
            img_rank2: '/images/sinhnhat11nam/img_main/rank2.png',
            img_rank3: '/images/sinhnhat11nam/img_main/rank3.png',
            clickedThele: false,
            friendCode: "",
            rewardFlag: false,
            inviteFlag: false,
            clickedtabThanhTuu: false,
            isPopupVisible: false,
            isDivVisible: false,
        };
    },
    created() {

    },
    methods: {
        ...authMethods,
        ...authGetters,

        async invite() {
            if (this.nhiemvu[4] && this.nhiemvu[4]['current_attempts'] < this.nhiemvu[4]['total_attempts']) {
                if (this.inviteFlag == false) {
                    this.inviteFlag = true;
                    let user = await this.users();
                    let self = this;
                    axios.get('/api/invite', {
                        params: {
                            user_code: this.friendCode,
                            user_name: user.name
                        },
                    })
                        .then(function (response) {
                            self.inviteFlag = false;
                            if (response.data.status === 200 && response.data.success == true) {
                                // self.nhiemvu = response.data.data.nhiemvu;
                                self.updateNhiemvuTtt(response.data.data.quests)
                                // if (response.data.data.user) {
                                //     // const userResponseJSON = JSON.stringify(response.data.data.user);
                                //     // self.saveInfoUser(userResponseJSON);

                                //     // self.diamond = response.data.data.user.diamond

                                //     // self.attrKimcuong = response.data.user.diamond;
                                //     // self.feathers = response.data.data.user.feathers
                                //     self.$emit("updateAttrKimcuong", response.data.data.user.diamond);
                                //     self.$emit("updateAttrLongvu", response.data.data.user.feathers);
                                //     // this.$store.actions.saveInfoUser(response.data.data.user);
                                // }
                                self.$swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                            }
                            if (response.data.status === 200 && response.data.success == false) {
                                self.$swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        })
                        .catch((error) => {
                            self.inviteFlag = false;
                            if (error.response && error.response.status === 401) {
                                this.logoutSubmit()
                            }
                            console.log(error);
                        })
                        .finally();
                }

            } else {
                console.log("this.nhiemvu[4]",this.nhiemvu[4]);
                this.$swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Bạn đã mời đủ 10 phù thủy đi học chung!",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },
        async logoutSubmit() {
            await this.logout();
        },
        async getReWard(questId) {
            if (this.rewardFlag == false) {
                this.rewardFlag = true;
                let user = await this.users();
                let self = this;
                axios.get('/api/get-reward', {
                    params: {
                        quest_id: questId,
                        user_name: user.name
                    },
                })
                    .then(function (response) {
                        self.rewardFlag = false;
                        if (response.data.status === 200) {
                            if (response.data.success == true) {
                                // self.nhiemvu = response.data.data.nhiemvu;

                                console.log("response.data.data.quests", response.data.data.quests);
                                self.updateNhiemvuTtt(response.data.data.quests);
                                if (response.data.data.user) {
                                    self.$emit("updateAttrKimcuong", response.data.data.user.diamond);
                                    self.$emit("updateAttrLongvu", response.data.data.user.feathers);
                                }
                                if (response.data.data.log_activity) {
                                    let dataLog = response.data.data.log_activity ?? [];
                                    let logActivity = []
                                    dataLog.forEach(element => {
                                        logActivity.push({
                                            "reason": element.reason,
                                            "log_item": JSON.parse(element.log_item ?? "[]"),
                                            "name": element.name,
                                            "formatted_created_at": element.formatted_created_at
                                        });
                                    });

                                    self.updateLogActivityTtt(logActivity);
                                }
                                // alert(response.data.message);
                                // self.$swal.fire({
                                //     position: "center",
                                //     icon: "success",
                                //     title: response.data.message,
                                //     showConfirmButton: false,
                                //     timer: 1500
                                // });

                                self.$swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                if (response.data.data.quests) {
                                    // self.nhiemvu = response.data.data.nhiemvu;
                                    console.log("response.data.data.quests", response.data.data.quests);
                                    self.updateNhiemvuTtt(response.data.data.quests);
                                }
                                // alert(response.data.message);
                                self.$swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    })
                    .catch((error) => {
                        self.rewardFlag = false;
                        console.log(error);
                        if (error.response && error.response.status === 401) {
                            this.logoutSubmit()
                        }
                    })
                    .finally();
            }

        },
        updateNhiemvuTtt(newValue) {
            console.log("updateNhiemvuTtt newValue:", newValue);
            this.$emit("updateNhiemvu", newValue);
        },
        updateLogActivityTtt(newValue) {
            this.$emit("updateLogActivity", newValue);
        },

        copyContent() {

            const el = document.createElement('textarea');
            el.value = this.user_code;
            const existingElement = document.querySelector('.modalThapThanhTuu');
            existingElement.appendChild(el);
            el.select();
            document.execCommand('copy');
            existingElement.removeChild(el);
            this.$toast.success('Liên kết đã được sao chép', {
                autoClose: 1500,
            });
        },

        GotoNhaThiDau(){
            $('.modalThapThanhTuu').modal('hide');
            $('.modalNhaThiDau').modal('show');
        },

        GotoThuVien(){
            $('.modalThapThanhTuu').modal('hide');
            $('.modalThuVien').modal('show');
        },

        


        // startShowPopup() {
        //     setTimeout(() => {
        //         // Sau 5 giây, hiển thị popup bằng cách thay đổi trạng thái
        //         this.isPopupVisible = true;
        //     }, 5000); // 5000 milliseconds = 5 giây
        // },

        doneInstructions() {
            this.clickedtabThanhTuu = true;

            setTimeout(() => {
                this.isDivVisible = true;
                setTimeout(() => {
                    this.isDivVisible = false;
                }, 5000);
            }, 3000);

            axios.get('/api/done-instructions', {})
                .then(function (response) {
                    if (response.data.status === 200) {

                    }
                })
                .catch((error) => {
                    self.rewardFlag = false;
                    console.log(error);
                    if (error.response && error.response.status === 401) {
                        this.logoutSubmit()
                    }
                })
                .finally();
        },
    },
    mounted() {
        setTimeout(() => {
            // Sau 5 giây, hiển thị popup bằng cách thay đổi trạng thái
            this.isPopupVisible = true;
        }, 5000); // 5000 milliseconds = 5 giây
    },
};
</script>

<style>.tab-thanhtuu {
    position: absolute;
    top: 195px;
    left: -148px;
}

.tab-thanhtuu .nav-link {
    /* background: cyan; */
    transition: all 0.3s linear;
    /* Sử dụng transition cho width và left */
    width: 185px;
    height: 81px;
    background: url('../../../../../assets/images/sinhnhat11nam/img_main/tab-nonactive.png');
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tab-thanhtuu .nav-link.active {
    background-color: transparent;
    background: url('../../../../../assets/images/sinhnhat11nam/img_main/tab-active.png');
    margin-left: -40px;
    width: 225px;
}

.tab-thanhtuu .nav-item a {
    font-size: 18px;
    color: #292c48;
    text-transform: uppercase;
}

.tab-thanhtuu .nav-item a.active {
    color: #8e6245;
}

#ThapThanhTuu-Modal .tab-pane .task {
    max-height: 415px;
    overflow-y: auto;
}

@keyframes expandWidth {
    0% {
        width: 100px;
    }

    100% {
        width: 200px;
    }
}

.title-modal {
    font-family: "UTMGodsWordBold";
    text-transform: uppercase;
    color: #4d4b39;
    text-align: center;
}

#ThapThanhTuu-Modal .tab-pane .task .item-task {
    padding-right: 0;
    position: relative;
}

#ThapThanhTuu-Modal .tab-pane .task .item-task span.stt{
    position: absolute;
    left: -35px;
    font-size: 16px;
    font-weight:bold;
}

#ThapThanhTuu-Modal .tab-pane .task::-webkit-scrollbar-track,
#v-tabs-the-le .content::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #F5F5F5;
    border-radius: 10px;
}

#ThapThanhTuu-Modal .tab-pane .task::-webkit-scrollbar,
#v-tabs-the-le .content::-webkit-scrollbar {
    width: 10px;
    background-color: transparent;
}

#ThapThanhTuu-Modal .tab-pane .task::-webkit-scrollbar-thumb,
#v-tabs-the-le .content::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background-image: -webkit-gradient(linear,
            left bottom,
            left top,
            color-stop(0.44, rgb(217, 203, 122)),
            color-stop(0.72, rgb(189, 168, 73)),
            color-stop(0.86, rgba(158, 124, 14, 0.836)));
}

.item-task .star {
    font-size: 36px;
    margin-left: -27px;
}

.item-task {
    background: #edebdc;
    margin-bottom: 15px;
}

.item-button {
    transition: all 0.3s linear;
    position: relative;
    cursor: pointer;
}

.item-button button {
    border: none;
}

.item-button-active{
    -webkit-animation: glowing 1500ms infinite;
    -moz-animation: glowing 1500ms infinite;
    -o-animation: glowing 1500ms infinite;
    animation: glowing 1500ms infinite;
}

.item-button span.diamond-reward {
    position: absolute;
    right: 2px;
    bottom: 0;
    color: #F5F5F5;
    font-family: 'Tahoma';
}

.item-button:hover {
    filter: brightness(150%);
}

.item-info {
    font-family: 'Tahoma';
}

.thanhtich .item-task {
    border-radius: 5px;
}

.thanhtich .avatar img {
    border-radius: 50%;
}

.attr-longvu p {
    display: inline-block;
}

.lich-tuong-ky .item-task {
    background: none;
}

.lich-tuong-ky .item-reason,
.item-task .item-created-at {
    background: #edebdc;
}

.friendcode {
    max-height: 45px;
}

.friendcode input {
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
}

.friendcode button {
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
}

.user_code {
    margin-left: 40px;
    display: flex;
    margin-bottom: 10px;
    align-items: center;
}

.user_code button {
    margin-left: 5px;
}

.img-phoenix img {
    position: fixed;
    top: 30%;
    padding-top: 50px;
}

#v-tabs-the-le .content {
    height: 415px;
    overflow-y: auto;
    padding: 0 50px;
}



#ThapThanhTuu-Modal .div-img.mui-ten img {
    transform: rotateZ(45deg);
    z-index: 2;
}

#ThapThanhTuu-Modal .div-img.mui-ten {
    position: absolute;
    left: -20%;
    top: 10%;
}

#ThapThanhTuu-Modal .div-img.mui-ten.nhan-da {
    /* position: absolute;
    left: 34%;
    top: 34%; */

    position: fixed;
    left: 40%;
    top: 35%;
}

#ThapThanhTuu-Modal .div-img.mui-ten {
    -webkit-animation: mover 0.5s infinite alternate;
    animation: mover 0.5s infinite alternate;
}

#ThapThanhTuu-Modal .div-img.mui-ten {
    -webkit-animation: mover 0.5s infinite alternate;
    animation: mover 0.5s infinite alternate;
}

@-webkit-keyframes mover {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-10px);
    }
}

@keyframes mover {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-10px);
    }
}

#ThapThanhTuu-Modal .div-img.mui-ten .popup {
    width: 280px;
    padding: 5px;
    border-radius: 5px;
    color: #ffffff;
    background: linear-gradient(to bottom, #f1c461, #a1813f);
    border: 1px solid #ffffff;
}

#ThapThanhTuu-Modal .div-img.mui-ten.nhan-da .popup {
    width: 170px;
    margin-bottom: -20px
}

@-webkit-keyframes glowing {
  0% { filter: brightness(120%); }
  50% { filter: brightness(150%); }
  100% { filter: brightness(120%); }
}
 
@-moz-keyframes glowing {
  0% { filter: brightness(120%); }
  50% { filter: brightness(150%); }
  100% { filter: brightness(120%); }
}
 
@-o-keyframes glowing {
  0% { filter: brightness(120%); }
  50% { filter: brightness(150%); }
  100% { filter: brightness(120%); }
}
 
@keyframes glowing {
  0% { filter: brightness(120%); }
  50% { filter: brightness(150%); }
  100% { filter: brightness(120%); }
}

button.goto{
    background: linear-gradient(to bottom, #fdd977, #efe4a3);
    border: 1px solid #ffffff;
    color: #4d4b39;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    border-radius: 5px;
    font-size:14px;
    padding: 1px 10px;
    display: none;
}

#v-tabs-thu-thach .item-task:hover:nth-child(2) .point p,
#v-tabs-thu-thach .item-task:hover:nth-child(3) .point p,
#v-tabs-thu-thach .item-task:hover:nth-child(4) .point p{
    display: none;
}

#v-tabs-thu-thach .item-task:hover:nth-child(2) .point button.goto,
#v-tabs-thu-thach .item-task:hover:nth-child(3) .point button.goto,
#v-tabs-thu-thach .item-task:hover:nth-child(4) .point button.goto{
    display: block;
}
</style>