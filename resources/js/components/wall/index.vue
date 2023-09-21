<script>
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css";
import WOW from "wow.js";
import "animate.css";
import $ from "jquery";
import Masonry from "masonry-layout";
import imagesLoaded from "imagesloaded";
import "remixicon/fonts/remixicon.css";
import {
    socketMethods,
    walltMethods,
    wallGetters,
    commentMethods,
} from "@/store/store";
import { socket } from "@/store/socket";
import Header from "@/components/layouts/Header";
import DetailPadlet from "@/components/wall/detail";
import { Helper } from "@/helper";
export default {
    components: {
        name: "MasonryLayout",
        DetailPadlet,
        Header,
        InfiniteLoading
    },
    data: () => {
        return {
            paginations:false,
            publicPath: process.env.PUBLIC_URL + "uploads/",
            items: [],
            listColor: [
                {
                    name: "Màu trắng",
                    color: "255,255,255",
                },
                {
                    name: "Màu đỏ",
                    color: "255,218,218",
                },
                {
                    name: "Màu vàng",
                    color: "255,244,206",
                },
                {
                    name: "Xanh lá",
                    color: "222,255,221",
                },
                {
                    name: "Xanh da trời",
                    color: "187,234,255",
                },
                {
                    name: "Màu tím",
                    color: "238,216,255",
                },
            ],
            masonry: null,
            data: {
                title: null,
                content: null,
                file: null,
                color: null,
            },
            currentPadlets: {},
            images: null,
            newImages:null,
            dataUser: {},
            hidden: false,
            expand: false,
            disabled: false,
            infoUsers: false,
            currentPadlets: false,
            checkMessenger: false,
            comment: [],
            showEditComment: [],
            oldContentComment: [],
            showSend: [],
            currentId: false,
            load:false,
            showScroll: false,
        };
    },
    computed: {
        ...wallGetters,
    },
    methods: {
        //...socketMethods,
        initializeMasonry() {
            console.log("initializeMasonry");
            this.masonry = new Masonry(this.$refs.masonryContainer, {
                itemSelector: ".masonry-item",
                columnWidth: ".masonry-sizer",
                percentPosition: true,
                transitionDuration: ".1s",
                gutter: ".gutter-sizer",
            });

            imagesLoaded(this.$refs.masonryContainer).on("progress", () => {
                this.masonry.layout();
            });
        },
        handleAddItem() {
            let item = { id: 1, text: "Item 5", classes: "grid-item--height2" };
            this.items.push(item);
        },
        // create
        handleFileUpload(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.data.file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.images = event.target.result;
            };
            reader.readAsDataURL(this.data.file);
        },

        handleFileUploadEdit(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.new_file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                this.currentPadlets.file_name = event.target.result;
            };
            reader.readAsDataURL(this.new_file);
        },

        async handleCreate() {
            const resultData = await this.createWall(this.data);
            if (resultData) {
                this.handleShowForm();
                //this.items.push(resultData);
                this.items.unshift(resultData);
                this.data = {
                    title: null,
                    content: null,
                    file: null,
                    color: null,
                };
                this.$nextTick(() => {
                    this.initializeMasonry();
                });
            }
        },

        handleShowFormEdit() {
            this.hidden = !this.hidden;
            if (this.hidden) {
                this.new_file = false
            }
        },
        async handleEditWall() {
            let dataUpdated = {};
                dataUpdated['file'] = this.new_file;
                dataUpdated['title'] = this.currentPadlets.title;
                dataUpdated['content'] = this.currentPadlets.content;
                dataUpdated['color'] = this.currentPadlets.color;
                dataUpdated['id'] = this.currentPadlets.id;
                dataUpdated['file_name'] = this.currentPadlets.file_name;
            const resultData = await this.updateWall(dataUpdated);
            if (resultData) {
                this.currentPadlets.file_name = resultData.file_name ? resultData.file_name : '';
                this.new_file = false;
                this.$refs.closeEditPadlet.click();
                this.items.filter((item) => {
                    if (item.id == resultData.id) {
                        item = resultData
                    }
                });
                this.$nextTick(() => {
                    this.initializeMasonry();
                });
            }
        },
        handleRemoveFile() {
            this.images = null;
            this.data.file = null;
        },
        handleRemoveFileEdit() {
            this.new_file = null;
            this.currentPadlets.file_name = null;
        },
        // hidden
        handleShowForm() {
            this.hidden = !this.hidden;
            if (this.hidden) {
                this.data = {
                    title: null,
                    content: null,
                    file: null,
                    color: null,
                };
                this.images = null;
            }
        },
        handleExpandForm() {
            this.expand = !this.expand;
        },
        handleDisabledForm() {
            if (
                this.data.file ||
                this.data.content ||
                this.data.title ||
                this.image
            ) {
                this.disabled = false;
                let checkTextTitle = Helper.checkRibaldry(this.data.title);
                let checkTextContent = Helper.checkRibaldry(this.data.content);
                if (checkTextContent | checkTextTitle) {
                    this.disabled = true;
                    this.checkMessenger = true;
                } else {
                    this.checkMessenger = false;
                }
            } else {
                this.disabled = true;
                this.checkMessenger = false;
            }
        },
        async handleUpadtedWall(e) {
            let currentWall = false;
            let id = e.target.getAttribute("data-id");
            let data = {};
            data["id"] = id;
            data["data_like"] = [];
            let data_like = [];
            currentWall = this.items.filter((item) => item.id == id);
            if (currentWall.length > 0) {
                currentWall = currentWall[0];
                if (currentWall["liked"]) {
                    data_like = JSON.parse(currentWall["data_like"]);
                    let check = data_like.some(
                        (item) => item.profile_id == this.dataUser.profile_id
                    );
                    if (check) {
                        currentWall["liked"] =
                            parseInt(currentWall["liked"]) - 1;
                        data_like = data_like.filter(
                            (item) =>
                                item.profile_id != this.dataUser.profile_id
                        );
                    } else {
                        currentWall["liked"] =
                            parseInt(currentWall["liked"]) + 1;
                        data_like.push({
                            profile_id: this.dataUser.profile_id,
                            fullname: this.dataUser.fullname,
                        });
                    }
                } else {
                    currentWall["liked"] = 1;
                    data_like.push({
                        profile_id: this.dataUser.profile_id,
                        fullname: this.dataUser.fullname,
                    });
                }
                currentWall["data_like"] = JSON.stringify(data_like);
                data["data_like"] = data_like;
                data["liked"] = currentWall["liked"];
            }
            let results = await this.updateWall(data);
            // if (results) {
            //     this.sendUpdateData(results);
            // }
        },
        checkLiked(item) {
            return JSON.parse(item).some(
                (i) => i.profile_id == this.dataUser.profile_id
            );
        },
        // show modal
        handleShowModal(id) {
            this.currentPadlets = this.items.filter((item) => item.id == id);
            this.currentPadlets = this.currentPadlets[0];
            this.currentPadlets.title = this.currentPadlets.title && this.currentPadlets.title != 'null' ? this.currentPadlets.title : "";
            this.currentPadlets.content = this.currentPadlets.content && this.currentPadlets.content != 'null' ? this.currentPadlets.content : "";
            this.currentPadlets.file_name = this.currentPadlets.file_name && this.currentPadlets.file_name != 'null' ? this.currentPadlets.file_name : "";
            this.currentPadlets.name = this.listColor.filter((item) => this.currentPadlets.color == item.color) ;
            this.currentPadlets.name = this.currentPadlets.name[0] ? this.currentPadlets.name[0]['name']  : "Màu Trắng";  
            this.$refs.padletModal.click();            
        },
        //Comment
        async handleAddComment(id) {
            if (this.comment[id]) {
                try {
                    let checkComment = Helper.checkRibaldry(this.comment[id]);
                    if (checkComment) {
                        alert("Vui lòng không dùng từ ngữ kiếm nhã");
                        return;
                    }
                    let data = {};
                    data["content"] = this.comment[id];
                    data["target_id"] = id;
                    data["profile_id"] = this.dataUser.profile_id;
                    let results = await this.createComment(data);
                    if (results) {
                        this.items.filter((item) => {
                            if (id == item.id) {
                                item.comments.push(results);
                            }
                        });
                        this.comment = [];
                        this.initializeMasonry();
                        this.showIconSendComment();
                    }
                } catch (error) {
                    console.log("Lỗi khi post comment");
                }
            }
        },
        // show edit comment
        editComment(id, padlet_id) {
            this.showEditComment = [];
            this.showEditComment[id] = true;
            //oldContentComment
            let oldData = this.items.filter((item) => padlet_id == item.id);
            if (oldData) {
                let oldComment = oldData[0]["comments"].filter(
                    (item) => id == item.id
                );
                if (oldComment) {
                    oldComment = oldComment[0];
                    this.oldContentComment[id] = oldComment.content;
                }
            }
        },
        handleCancelComment(id, padlet_id) {
            this.showEditComment = [];
            this.items.filter((item) => {
                if (padlet_id == item.id) {
                    item.comments.filter((_item) => {
                        if (_item.id == id)
                            _item.content = this.oldContentComment[id];
                    });
                }
            });
        },
        // updated comments
        async handleUpdateComment(id, padlet_id) {
            try {
                let newContentComment = "";
                this.items.filter((item) => {
                    if (padlet_id == item.id) {
                        item.comments.filter((_item) => {
                            if (_item.id == id) {
                                newContentComment = _item.content;
                            }
                        });
                    }
                });
                if (newContentComment.length > 0) {
                    let data = {};
                    data["id"] = id;
                    data["content"] = newContentComment;
                    let checkComment = Helper.checkRibaldry(newContentComment);
                    if (checkComment) {
                        alert("Vui lòng không dùng từ ngữ kiếm nhã");
                        return;
                    }
                    var results = await this.updateComment(data);
                    if (results) {
                        this.showEditComment = [];
                        this.oldContentComment = [];
                        this.initializeMasonry();
                    }
                } else {
                    alert("Vui lòng nhập comment");
                }
            } catch (error) {
                console.log("error updated comment");
            }
        },
        // remove comments
        async handleRemoveComment(id, padlet_id) {
            try {
                let results = await this.deleteComment(id);
                let currentListComments = this.items.filter(
                    (item) => item.id == padlet_id
                );
                let listComment;
                listComment = currentListComments[0]["comments"].filter(
                    (_item, index) => {
                        return _item.id != id;
                    }
                );
                this.items.filter((item) => {
                    if (padlet_id == item.id) {
                        item.comments = listComment;
                    }
                });
                this.initializeMasonry();
            } catch (error) {
                console.log("Error delete comment");
            }
        },
        handleGetId(id) {
            this.currentId = id;
        },
        // show icon send comment
        showIconSendComment() {
            if (this.currentId) {
                if (this.comment[this.currentId]) {
                    this.showSend[this.currentId] = true;
                } else {
                    this.showSend = [];
                }
            }
        },
        ...walltMethods,
        ...commentMethods,
        async infiniteHandler(){           
            if (this.paginations['current-page']) {
                this.showScroll = true;
                this.load = true;
                let page = parseInt(this.paginations['current-page']) + 1;
                let data = {};
                data['page'] = page;
                if (page <= parseInt(this.paginations['total-page'])) {
                    let dataFetch = await this.indexWall(data);
                    if (dataFetch.data) {
                        this.paginations = {}
                        this.paginations['current-page'] = page;
                        this.paginations['total-page'] = dataFetch.last_page;
                        if (dataFetch.data.length > 0) {
                            for (let index = 0; index < dataFetch.data.length; index++) {
                                const element = dataFetch.data[index];
                                this.items.push(element);
                            }
                            this.$nextTick(() => {
                                this.initializeMasonry();
                            });
                            this.load = false;
                        }
                    }
                }
                
            }
        },
        scrollToTop() {
            var element = document.getElementById("wrapper-padlet");
            var top = element.offsetTop;
            element.scrollTo(0, top);
            element.scrollTo({
                top: 0,
                left: 0,
                behavior: "smooth",
            });
            this.showScroll = false;
        }
    },
    watch: {},
    updated() {
        const $this = this;
        $(document).ready(function () {
            $(".nav-main").addClass("hidden-header");
            $("body").addClass("overflow-hidden");
            $(".drop-color-1 .dropdown-item").on("click", function () {
                var $color = $(this).find(".color").attr("data-color");
                var $name = $(this).find(".color").attr("data-name");
                $this.data.color = $color ? $color : "255,255,255";
                $("#dropContent").find(".name").text($name);
                $("#dropContent")
                    .find(".color")
                    .css("background-color", "rgb(" + $color + ")");
            });
            $this.handleDisabledForm();
            autoSizeTextArea();
            function autoSizeTextArea() {
                var text = $(".autosize");
                text.each(function () {
                    $(this).attr("rows", 1);
                    resize($(this));
                });
                text.on("input", function () {
                    $this.showIconSendComment();
                    resize($(this));
                });
                function resize($text) {
                    $text.css("height", "auto");
                    $text.css("height", $text[0].scrollHeight + "px");
                }
            }
            $('#wrapper-padlet').scroll(function() {
                if ($(this).scrollTop() > 500) {
                    $this.showScroll = true
                } else {
                    $this.showScroll = false
                }
            });
        });
    },
    created() {},
    async mounted() {
        this.dataUser = JSON.parse(localStorage.getItem("users") || "{}");
        // let dataFetch = await this.indexWall();
        // this.items = await this.indexWall();
        let dataFetch = await this.indexWall();
        if (dataFetch.data) {
            this.paginations = {}
            this.paginations['current-page'] = dataFetch.current_page;
            this.paginations['total-page'] = dataFetch.last_page;
            this.items = dataFetch.data;
        }

        const $this = this;
        $(document).ready(function () {
            $this.initializeMasonry();
            $(".drop-color-2 .dropdown-item").on("click", function () {
                var $color = $(this).find(".color").attr("data-color");
                var $name = $(this).find(".color").attr("data-name");
                $this.data.color = $color ? $color : "255,255,255";
                if ($this.currentPadlets) {
                    $this.currentPadlets.color = $color ? $color : "255,255,255";
                    $this.$nextTick(()=>{
                        $this.initializeMasonry();
                    });
                }
                $("#dropContent").find(".name").text($name);
                $("#dropContent")
                    .find(".color")
                    .css("background-color", "rgb(" + $color + ")");
            });
        });

        // get data from server
        /*socket.on("listen data", function (data) {
            try {
                $this.items.push(data);
            } catch (error) {
                console.log("error ", error);
            }

            // socket.removeListener('listen messenger');
        });

        // get data from server
        socket.on("listen update data", function (data) {
            try {
                $this.items.filter((item) => {
                    if (item.id == data.id) {
                        item["liked"] = data["liked"];
                        item["data_like"] = data["data_like"];
                    }
                });
            } catch (error) {
                console.log("error ", error);
            }

            // socket.removeListener('listen messenger');
        });*/
    },
};
</script>
<template>
    <div class="wrap-padlet" id="wrapper-padlet">
        <div class="main-padlet">
            <div class="header-padlet container-fluid py-4 px-5">
                <Header></Header>
            </div>
            <div class="masonry" ref="masonryContainer">
                <div class="gutter-sizer"></div>
                <div class="masonry-sizer"></div>
                <div
                    v-for="item in items"
                    :key="item.id"
                    :class="['masonry-item pb-2 px-2 pt-2']"
                    v-bind:style="`background-color:rgb(${
                        item.color && item.color != 'null'
                            ? item.color
                            : '255,255,255'
                    })`"
                >
                    <div class="wrap-content">
                        <div
                            class="content-wall pb-2"
                            @click="handleShowModal(item.id)"
                        >
                            <div class="header">
                                <h5
                                    class="title"
                                    v-if="item.title && item.title != 'null'"
                                >
                                    {{ item.title }}
                                </h5>
                                <a
                                    class="wrap-tooltip"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    :title="
                                        item.users.first_name +
                                        ' ' +
                                        item.users.last_name
                                    "
                                >
                                    <img
                                        :src="item.users.avatar"
                                        :alt="
                                            item.users.first_name +
                                            ' ' +
                                            item.users.last_name
                                        "
                                    />
                                    <!-- <span class="name">{{ item.users.first_name + ' '+item.users.last_name }}</span> -->
                                </a>
                            </div>

                            <div class="images pt-2" v-if="item.file_name">
                                <img
                                    :src="`${publicPath + item.file_name}`"
                                    alt=""
                                />
                            </div>
                            <div
                                v-if="item.content && item.content != 'null'"
                                v-bind:innerHTML="`${item.content}`"
                                :class="['content-messenger pt-2']"
                            ></div>
                        </div>
                        <span class="border-dark"></span>
                        <div class="d-flex justify-content-between pt-2">
                            <span class="heart">
                                <i
                                    v-if="!item.liked || item.liked == 0"
                                    :class="`${'ri-heart-line'}`"
                                    @click="handleUpadtedWall"
                                    :data-id="item.id"
                                ></i>
                                <i
                                    v-else
                                    :class="`${
                                        checkLiked(item.data_like)
                                            ? 'ri-heart-fill'
                                            : 'ri-heart-line'
                                    }`"
                                    @click="handleUpadtedWall"
                                    :data-id="item.id"
                                ></i>
                                <small>{{
                                    item.liked && item.liked != 0
                                        ? item.liked
                                        : ""
                                }}</small>
                            </span>
                            <span class="comment"
                                ><i class="ri-chat-3-line"></i
                                ><small>{{
                                    item.comments && item.comments.length
                                        ? item.comments.length
                                        : ""
                                }}</small></span
                            >
                        </div>
                        <div class="">
                            <div
                                class="list-messenger mt-3"
                                v-if="item.comments && item.comments.length"
                            >
                                <div
                                    class="d-flex mt-2"
                                    v-for="comment in item.comments"
                                    :key="comment.id"
                                >
                                    <div class="avatar">
                                        <img :src="comment.avatar" alt="" />
                                    </div>
                                    <div class="content-messenger">
                                        <div class="">
                                            <div
                                                class="d-flex justify-content-between"
                                            >
                                                <h6 class="name">
                                                    {{ comment.fullname }}
                                                </h6>
                                                <div class="more-button">
                                                    <div class="btn-group">
                                                        <button
                                                            type="button"
                                                            class="btn btn-light btn-sm dropdown-toggle border-0 px-0 pb-0 pt-0"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                        >
                                                            <i
                                                                class="ri-more-2-fill"
                                                            ></i>
                                                        </button>
                                                        <ul
                                                            class="dropdown-menu pt-0 pb-0"
                                                            v-if="
                                                                dataUser.profile_id ==
                                                                comment.profile_id
                                                            "
                                                        >
                                                            <li
                                                                class="d-flex px-2"
                                                                @click="
                                                                    editComment(
                                                                        comment.id,
                                                                        item.id
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    ><i
                                                                        class="ri-pencil-line"
                                                                    ></i></span
                                                                ><span
                                                                    >Chỉnh sửa
                                                                    bình
                                                                    luận</span
                                                                >
                                                            </li>
                                                            <li
                                                                class="d-flex px-2 color-red"
                                                                @click="
                                                                    handleRemoveComment(
                                                                        comment.id,
                                                                        item.id
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    ><i
                                                                        class="ri-delete-bin-line"
                                                                    ></i></span
                                                                ><span
                                                                    >Xoá bình
                                                                    luận</span
                                                                >
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <p
                                                v-if="
                                                    !showEditComment[comment.id]
                                                "
                                            >
                                                {{ comment.content }}
                                            </p>
                                        </div>
                                        <div
                                            class="messenger"
                                            v-if="showEditComment[comment.id]"
                                        >
                                            <textarea
                                                class="autosize"
                                                v-model="comment.content"
                                            ></textarea>
                                            <div
                                                class="d-flex justify-content-end mt-2 mb-2"
                                            >
                                                <button
                                                    class="btn btn-outline-secondary btn-sm me-2"
                                                    @click="
                                                        handleCancelComment(
                                                            comment.id,
                                                            item.id
                                                        )
                                                    "
                                                >
                                                    Huỷ
                                                </button>
                                                <button
                                                    class="btn btn-outline-primary btn-sm"
                                                    @click="
                                                        handleUpdateComment(
                                                            comment.id,
                                                            item.id
                                                        )
                                                    "
                                                >
                                                    Cập nhập
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="avatar">
                                    <img :src="dataUser.avatar" alt="" />
                                </div>
                                <div class="form-messenger">
                                    <textarea
                                        @click="handleGetId(item.id)"
                                        class="autosize"
                                        v-model="comment[item.id]"
                                        placeholder="Thêm bình luận"
                                    ></textarea>
                                    <span
                                        class="send"
                                        @click="handleAddComment(item.id)"
                                        v-if="showSend[item.id]"
                                    >
                                        <i class="ri-arrow-right-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                :class="[
                    'wrap-model w-100 wrapper-model',
                    `${expand ? 'show' : ''}`,
                ]"
                v-if="hidden"
            >
                <span class="close" @click="handleShowForm"></span>
                <form
                    class="wrapper-form"
                    action=""
                    @submit.prevent="handleCreate"
                >
                    <div
                        class="d-flex flex-row justify-content-between pt-3 pb-2 px-3"
                    >
                        <ul class="navbar-nav d-flex flex-row">
                            <li class="nav-item me-2" @click="handleShowForm">
                                <span class="btn btn-light">
                                    <i class="ri-close-line"></i>
                                </span>
                            </li>
                            <li class="nav-item">
                                <span
                                    class="btn btn-light"
                                    @click="handleExpandForm"
                                >
                                    <i
                                        :class="`${
                                            expand
                                                ? 'ri-arrow-right-down-line'
                                                : 'ri-arrow-left-up-line'
                                        }`"
                                    ></i>
                                </span>
                            </li>
                        </ul>
                        <div class="d-flex fjustify-content-end ps-3">
                            <button
                                ref="buttonSubmit"
                                type="submit"
                                class="btn btn-outline-primary"
                                :disabled="disabled ? true : null"
                            >
                                Xuất bảng
                            </button>
                        </div>
                    </div>
                    <div class="wrap-form-group pt-1 pb-2 px-3">
                        <div class="form-group">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Chủ đề"
                                v-model="data.title"
                            />
                        </div>
                        <div class="form-group bg-images-file d-flex">
                            <div class="images" v-if="images">
                                <img :src="images" alt="" />
                                <span
                                    class="btn remove-file"
                                    @click="handleRemoveFile"
                                    >Gỡ bỏ</span
                                >
                            </div>
                            <div
                                class="d-flex justify-content-center w-100 align-items-center"
                                v-else
                            >
                                <div class="button-upload button-choice">
                                    <div class="icon green">
                                        <svg
                                            width="32"
                                            height="37"
                                            viewBox="0 0 32 37"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M11.894 1.183a7.716 7.716 0 0 1 8.212 0l7.788 4.835C30.435 7.595 32 10.51 32 13.665v9.67c0 3.155-1.565 6.07-4.106 7.647l-7.788 4.835a7.716 7.716 0 0 1-8.212 0l-7.788-4.835C1.566 29.404 0 26.49 0 23.335v-9.67c0-3.155 1.565-6.07 4.106-7.647l7.788-4.835z"
                                            />
                                        </svg>
                                        <span class="upload"
                                            ><i class="ri-camera-fill"></i
                                        ></span>
                                    </div>
                                    <input
                                        class="form-control"
                                        type="file"
                                        id="formFile"
                                        @change="handleFileUpload"
                                        accept="image/*"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea
                                class="form-control"
                                rows="3"
                                placeholder="Viết một điều gì đó..."
                                v-model="data.content"
                            ></textarea>
                        </div>
                        <span class="error-message" v-if="checkMessenger"
                            >Vui lòng không sử dụng từ ngữ tục tĩu</span
                        >
                    </div>

                    <div class="btn-group dropup">
                        <button
                            type="button"
                            class="btn btn-secondary dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            id="dropContent"
                        >
                            <span
                                class="color"
                                v-bind:style="`background-color:rgb(255,255,255)`"
                            ></span>
                            <span class="name">Màu trắng</span>
                        </button>
                        <ul class="dropdown-menu drop-color-1" id="dropColor">
                            <li
                                v-for="(item, index) in listColor"
                                :key="index"
                                class="dropdown-item"
                            >
                                <span
                                    class="color"
                                    v-bind:style="`background-color:rgb(${item.color})`"
                                    :data-color="`${item.color}`"
                                    :data-name="`${item.name}`"
                                ></span>
                                <p>{{ item.name }}</p>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="addPadlet pulse" @click="handleShowForm">
                <span class=""><i class="ri-add-line"></i></span>
            </div>            
            <infinite-loading  @infinite="infiniteHandler"></infinite-loading>
            <!-- <div class="d-flex justify-content-center" v-if="load">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div> -->
            <!-- InfiniteLoading -->
        </div>
    </div>
    <div class="addPadlet scrolltop" @click="scrollToTop" v-if="showScroll">
                <span class=""><i class="ri-arrow-up-s-line"></i></span>
            </div>
    <button
        type="button"
        class="btn btn-primary showModal"
        data-bs-toggle="modal"
        data-bs-target="#padletModal"
        ref="padletModal"
    ></button>

    <!-- Modal -->
    <div
        class="modal fade"
        id="padletModal"
        tabindex="-1"
        aria-labelledby="padletModal"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div
                class="modal-content"
                v-bind:style="`background-color:rgb${
                    currentPadlets.color && currentPadlets.color != 'null'
                        ? currentPadlets.color
                        : '255,255,255'
                }})`"
            >
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                    <i class="ri-close-line"></i>
                </button>
                <div class="modal-body">
                    <div class="wrap-content">
                        <div class="content-wall pb-2">
                            <div class="header">
                                <h5
                                    class="title"
                                    v-if="
                                        currentPadlets.title &&
                                        currentPadlets.title != 'null'
                                    "
                                >
                                    {{ currentPadlets.title }}
                                </h5>
                                <a
                                    class="wrap-tooltip"
                                    v-if="currentPadlets"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    :title="
                                        currentPadlets &&
                                        currentPadlets.users.fullname
                                            ? currentPadlets.users.first_name +
                                              ' ' +
                                              currentPadlets.users.last_name
                                            : ''
                                    "
                                >
                                    <img
                                        :src="currentPadlets.users.avatar"
                                        :alt="
                                            currentPadlets.users.first_name +
                                            ' ' +
                                            currentPadlets.users.last_name
                                        "
                                    />
                                    <!-- <span class="name">{{ currentPadlets.users.first_name+' ' +currentPadlets.users.last_name}}</span> -->
                                </a>
                            </div>
                            <div
                                class="images pt-2"
                                v-if="currentPadlets.file_name"
                            >
                                <img
                                    :src="`${
                                        publicPath + currentPadlets.file_name
                                    }`"
                                    alt=""
                                />
                            </div>
                            <div
                                v-if="
                                    currentPadlets.content &&
                                    currentPadlets.content != 'null'
                                "
                                v-bind:innerHTML="`${currentPadlets.content}`"
                                :class="['content-messenger pt-2']"
                            ></div>
                        </div>
                        <span class="border-dark"></span>
                        <div class="d-flex justify-content-between pt-2">
                            <span class="heart">
                                <i
                                    v-if="
                                        !currentPadlets.liked ||
                                        currentPadlets.liked == 0
                                    "
                                    :class="`${'ri-heart-line'}`"
                                    @click="handleUpadtedWall"
                                    :data-id="currentPadlets.id"
                                ></i>
                                <i
                                    v-else
                                    :class="`${
                                        checkLiked(currentPadlets.data_like)
                                            ? 'ri-heart-fill'
                                            : 'ri-heart-line'
                                    }`"
                                    @click="handleUpadtedWall"
                                    :data-id="currentPadlets.id"
                                ></i>
                                <small>{{
                                    currentPadlets.liked &&
                                    currentPadlets.liked != 0
                                        ? currentPadlets.liked
                                        : ""
                                }}</small>
                            </span>
                            <span class="comment"
                                ><i class="ri-chat-3-line"></i
                                ><small>{{
                                    currentPadlets &&
                                    currentPadlets.comments.length
                                        ? currentPadlets.comments.length
                                        : ""
                                }}</small></span
                            >
                        </div>
                        <div class="">
                            <div
                                class="list-messenger mt-3"
                                v-if="
                                    currentPadlets &&
                                    currentPadlets.comments.length
                                "
                            >
                                <div
                                    class="d-flex mt-2"
                                    v-for="comment in currentPadlets.comments"
                                    :key="comment.id"
                                >
                                    <div class="avatar">
                                        <img :src="comment.avatar" alt="" />
                                    </div>
                                    <div class="content-messenger">
                                        <div class="">
                                            <div
                                                class="d-flex justify-content-between"
                                            >
                                                <h6 class="name">
                                                    {{ comment.fullname }}
                                                </h6>
                                                <div class="more-button">
                                                    <div class="btn-group">
                                                        <button
                                                            type="button"
                                                            class="btn btn-light btn-sm dropdown-toggle border-0 px-0 pb-0 pt-0"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                        >
                                                            <i
                                                                class="ri-more-2-fill"
                                                            ></i>
                                                        </button>
                                                        <ul
                                                            class="dropdown-menu pt-0 pb-0"
                                                            v-if="
                                                                dataUser.profile_id ==
                                                                comment.profile_id
                                                            "
                                                        >
                                                            <li
                                                                class="d-flex px-2"
                                                                @click="
                                                                    editComment(
                                                                        comment.id,
                                                                        currentPadlets.id
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    ><i
                                                                        class="ri-pencil-line"
                                                                    ></i></span
                                                                ><span
                                                                    >Chỉnh sửa
                                                                    bình
                                                                    luận</span
                                                                >
                                                            </li>
                                                            <li
                                                                class="d-flex px-2 color-red"
                                                                @click="
                                                                    handleRemoveComment(
                                                                        comment.id,
                                                                        currentPadlets.id
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    ><i
                                                                        class="ri-delete-bin-line"
                                                                    ></i></span
                                                                ><span
                                                                    >Xoá bình
                                                                    luận</span
                                                                >
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <p
                                                v-if="
                                                    !showEditComment[comment.id]
                                                "
                                            >
                                                {{ comment.content }}
                                            </p>
                                        </div>
                                        <div
                                            class="messenger"
                                            v-if="showEditComment[comment.id]"
                                        >
                                            <textarea
                                                class="autosize"
                                                v-model="comment.content"
                                            ></textarea>
                                            <div
                                                class="d-flex justify-content-end mt-2 mb-2"
                                            >
                                                <button
                                                    class="btn btn-outline-secondary btn-sm me-2"
                                                    @click="
                                                        handleCancelComment(
                                                            comment.id,
                                                            currentPadlets.id
                                                        )
                                                    "
                                                >
                                                    Huỷ
                                                </button>
                                                <button
                                                    class="btn btn-outline-primary btn-sm"
                                                    @click="
                                                        handleUpdateComment(
                                                            comment.id,
                                                            currentPadlets.id
                                                        )
                                                    "
                                                >
                                                    Cập nhập
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="avatar">
                                    <img :src="dataUser.avatar" alt="" />
                                </div>
                                <div class="form-messenger">
                                    <textarea
                                        @click="handleGetId(currentPadlets.id)"
                                        class="autosize"
                                        v-model="comment[currentPadlets.id]"
                                        placeholder="Thêm bình luận"
                                    ></textarea>
                                    <span
                                        class="send"
                                        @click="
                                            handleAddComment(currentPadlets.id)
                                        "
                                        v-if="showSend[currentPadlets.id]"
                                        ><i class="ri-arrow-right-line"></i
                                    ></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-3 justify-content-end" v-if="currentPadlets && dataUser.profile_id == currentPadlets.users.profile_id">
                            <button
                            type="button"
                            class="btn btn-outline-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editPadlet"
                            ref="editPadlet"
                            
                        >
                            Sửa
                        </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="modal fade"
        id="editPadlet"
        aria-hidden="true"
        aria-labelledby="editPadlet"
        tabindex="-1"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="wrapper-model show w-100">
                    <form
                        class="wrapper-form"
                        action=""
                        @submit.prevent="handleEditWall"
                        
                    >
                        <div
                            class="d-flex flex-row justify-content-between pt-3 pb-2 px-3"
                        >
                            <ul class="navbar-nav d-flex flex-row">
                                <li
                                    class="nav-item me-2"
                                >
                                    <span class="btn btn-light"  data-bs-dismiss="modal" aria-label="Close" ref="closeEditPadlet">
                                        <i class="ri-close-line"></i>
                                    </span>
                                </li>
                            </ul>
                            <div class="d-flex fjustify-content-end ps-3">
                                <button
                                    ref="buttonSubmit"
                                    type="submit"
                                    class="btn btn-outline-primary"
                                >
                                    Chỉnh sửa
                                </button>
                            </div>
                        </div>
                        <div class="wrap-form-group pt-1 pb-2 px-3">
                            <div class="form-group">
                                <input
                                    type="text autosize"
                                    class="form-control"
                                    placeholder="Chủ đề"
                                    v-model="currentPadlets.title"
                                />
                            </div>
                            <div class="form-group bg-images-file d-flex">
                                <div class="images" v-if="currentPadlets.file_name">
                                    <img :src="`${
                                        publicPath + currentPadlets.file_name
                                    }`" alt="" v-if="currentPadlets.file_name && !new_file"/>
                                    <img :src="currentPadlets.file_name" alt="" v-if="currentPadlets.file_name && new_file"/>
                                    <span
                                        class="btn remove-file"
                                        @click="handleRemoveFileEdit"
                                        >Gỡ bỏ</span
                                    >
                                </div>
                                <div
                                    class="d-flex justify-content-center w-100 align-items-center"
                                    v-else
                                >
                                    <div class="button-upload button-choice">
                                        <div class="icon green">
                                            <svg
                                                width="32"
                                                height="37"
                                                viewBox="0 0 32 37"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M11.894 1.183a7.716 7.716 0 0 1 8.212 0l7.788 4.835C30.435 7.595 32 10.51 32 13.665v9.67c0 3.155-1.565 6.07-4.106 7.647l-7.788 4.835a7.716 7.716 0 0 1-8.212 0l-7.788-4.835C1.566 29.404 0 26.49 0 23.335v-9.67c0-3.155 1.565-6.07 4.106-7.647l7.788-4.835z"
                                                />
                                            </svg>
                                            <span class="upload"
                                                ><i class="ri-camera-fill"></i
                                            ></span>
                                        </div>
                                        <input
                                            class="form-control"
                                            type="file"
                                            id="formFile"
                                            @change="handleFileUploadEdit"
                                            accept="image/*"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea
                                    class="form-control autosize"
                                    rows="3"
                                    placeholder="Viết một điều gì đó..."
                                    v-model="currentPadlets.content"
                                ></textarea>
                            </div>
                            <span class="error-message" v-if="checkMessenger"
                                >Vui lòng không sử dụng từ ngữ tục tĩu</span
                            >
                        </div>

                        <div class="btn-group dropup">
                            <button
                                type="button"
                                class="btn btn-secondary dropdown-toggle"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                id="dropContent"
                            >
                                <span
                                    class="color"
                                    v-bind:style="`background-color:rgb(${currentPadlets.color})`"
                                ></span>
                                <span class="name">{{ currentPadlets.name }}</span>
                            </button>
                            <ul class="dropdown-menu drop-color-2" id="dropColor">
                                <li
                                    v-for="(item, index) in listColor"
                                    :key="index"
                                    class="dropdown-item"
                                >
                                    <span
                                        class="color"
                                        v-bind:style="`background-color:rgb(${item.color})`"
                                        :data-color="`${item.color}`"
                                        :data-name="`${item.name}`"
                                    ></span>
                                    <p>{{ item.name }}</p>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped lang="scss">
.ps {
    height: 500px;
}
.add {
    position: fixed;
    right: 10px;
    bottom: 0;
}
.masonry {
    margin-left: 1%;
}
.gutter-sizer {
    width: 2%;
}
.masonry-sizer {
    width: 14.66666667%;
}
.wrap-content {
    .header {
        position: relative;
        padding-right: 30px;
        min-height: 30px;
        img {
            width: 30px;
            height: 30px;
            position: absolute;
            right: 0;
            object-fit: fill;
            top: 0;
            border-radius: 100%;
        }
        .wrap-tooltip {
            position: absolute;
            right: 0;
            top: 0;
            &:hover {
                span {
                    opacity: 1;
                    transition: all 0.3 ease-in-out;
                }
            }
            span {
                background: #fff;
                color: #777;
                font-size: 14px;
                font-weight: bold;
                text-decoration: none;
                position: absolute;
                right: 0;
                min-width: 100px;
                padding: 3px 5px;
                font-size: 12px;
                text-align: center;
                border-radius: 6px;
                bottom: -63px;
                box-shadow: 0px 0px 2px 0px rgba(0, 0, 0, 0.3);
                opacity: 0;
                transition: all 0.3 ease-in-out;
                &::before {
                    content: "";
                    position: absolute;
                    top: -5px;
                    right: 9px;
                    background-color: #fff;
                    width: 8px;
                    height: 8px;
                    transform: rotate(45deg);
                    border-top: 1px solid rgba(0, 0, 0, 0.2);
                    border-left: 1px solid rgba(0, 0, 0, 0.2);
                }
            }
        }
    }
    color: rbg(17, 17, 17);
    h5 {
        color: rbg(17, 17, 17);
    }
    img {
        width: 100%;
        border-radius: 0.75rem;
    }
    .border-dark {
        display: block;
        border: 0;
        border-bottom: 1px solid rgba(29, 29, 29, 0.2) !important;
    }
    .heart {
        cursor: pointer;
        display: flex;
        align-items: center;
        i {
            margin-right: 3px;
        }
        .ri-heart-fill {
            color: red;
        }
        &:hover {
            i {
                color: red;
            }
        }
    }
    .avatar {
        min-width: 25px;
        height: 25px;
        margin-right: 5px;
        max-width: 25px;
        img {
            border-radius: 100%;
            width: 100%;
            height: 100%;
            object-fit: fill;
        }
    }
    .more-button {
        .dropdown-toggle:after {
            display: none;
        }
        .dropdown-menu {
            left: auto !important;
            right: 0 !important;
            width: 175px !important;
            box-shadow: 0px 5px 10px 0px var(--bs-dropdown-divider-bg);
            li {
                cursor: pointer;
                position: relative;
                font-size: 14px;
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
                span {
                    display: inline-block;
                    &:first-child {
                        margin-right: 5px;
                    }
                }
                &.color-red {
                    color: red;
                }
                &:first-child {
                    &:after {
                        content: none;
                    }
                }
                &:after {
                    position: absolute;
                    height: 1px;
                    background: rgba(0, 0, 0, 0.2);
                    left: 0.5rem;
                    width: calc(100% - 1rem);
                    content: "";
                    top: 0;
                }
            }
        }
        .btn-sm {
            &.dropdown-toggle {
                background: transparent;
            }
        }
    }
    .content-messenger {
        width: 100%;
        .name {
            font-size: 13px;
            margin-bottom: 0;
            position: relative;
            top: 5px;
        }
        p {
            margin: 0;
            font-size: 13px;
        }
        .messenger {
        }
    }
    textarea {
        border: 0;
        font-size: 14px;
        width: 100%;
        resize: none;
        background-color: transparent;
        outline: none;
        &.autosize {
            min-height: 30px;
        }
    }
    .form-messenger {
        position: relative;
        width: 100%;
        textarea {
            padding-right: 20px;
        }
        .send {
            position: absolute;
            right: 0px;
            top: 5px;
            cursor: pointer;
        }
    }
}
#editPadlet {
    .modal-content {
        background: transparent;
        border:0;
        .wrapper-form {
            position: relative;
            transform: none;
            left: 0;
            right: 0;
        }
    }
}
.masonry-item {
    width: 15.66666667%;
    margin-bottom: 1%;
    background-color: #fff;
    border-radius: 0.75rem;
    .content-wall {
        cursor: pointer;
    }
}
.wrap-form-group {
    max-height: 400px;
    overflow-x: auto;
    .form-control {
        border: 0;
        &:focus {
            box-shadow: none;
        }
        resize: none;
        padding: 10px 0;
    }
    textarea.form-control {
        min-height: 170px;
    }
    .images {
        position: relative;
        width: 100%;
        img {
            width: 100%;
            border-radius: 0.75rem;
        }
        .remove-file {
            position: absolute;
            right: 1rem;
            bottom: 1rem;
            border-radius: 20px;
            box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.4);
            line-height: 20px;
            padding: 0 10px;
            font-size: 13px;
            background: rgba(255, 255, 255, 0.5);
            &:hover {
                background: rgba(255, 255, 255, 0.7);
            }
        }
    }
    .error-message {
        color: red;
        position: absolute;
        font-size: 14px;
        font-weight: bold;
        right: 1rem;
        bottom: 1rem;
    }
}
.scrolltop.addPadlet {
    bottom: calc(1rem + 70px);
    border: 2px solid transparent;
    transition: all 0.1s ease;
    transform: none;
    &:hover {
        background: #fff;
        color:rgb(200, 71, 53);
        border-color: rgb(200, 71, 53);
        transition: all 0.1s ease;
        i {
            transform: none;
            transition: all 0.1s ease;
            &::before {
                transform: none;
                transition: all 0.1s ease;
                content: "\ea78" !important;
            }
        }
    }
}
.addPadlet {
    position: fixed;
    right: 2rem;
    bottom: 1rem;
    z-index: 9;
    width: 60px;
    height: 60px;
    border-radius: 100%;
    background: rgb(200, 71, 53);
    transition: all 0.3s ease-in-out;
    transform: rotate(360deg);
    text-align: center;
    line-height: 60px;
    color: #fff;
    cursor: pointer;
    i {
        transform: rotate(0deg);
        transition: all 0.3s ease-in-out;
        font-size: 30px;
        &::before {
            transform: rotate(0deg);
            transition: all 0.3s ease-in-out;
        }
    }
    &:hover {
        i {
            transform: rotate(360deg);
            transition: all 0.3s ease-in-out;
            &::before {
                transform: rotate(360deg);
                transition: all 0.3s ease-in-out;
                content: "\efdf";
            }
        }
    }
}
.wrap-model {
    position: fixed;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    z-index: 10;
}
.wrapper-model {
    &.show {
        .wrapper-form {
            box-shadow: rgba(0, 0, 0, 0) 0px 0px 0px 0px,
                rgba(0, 0, 0, 0) 0px 0px 0px 0px,
                rgba(0, 0, 0, 0.16) 0px 8px 16px 0px;
            max-width: 540px;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 1.5rem;
            right: auto;
            margin: 0 auto;
        }
    }
    .close {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        z-index: 11;
        background-color: rgba(0, 0, 0, 0.2);
    }
    .wrapper-form {
        background-color: #fff;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        min-height: 350px;
        max-width: 405px;
        bottom: 0;
        right: 0;
        padding-bottom: 50px;
        position: absolute;
        z-index: 99;
        width: 100%;
        #dropContent {
            display: flex;
            background: rgb(245, 246, 247);
            transition: all 0.3s ease-in-out;
            color: rgba(17, 17, 17);
            padding: 5px 10px;
            border-color: rgb(245, 246, 247);
            font-size: 13px;
            &:hover {
                transition: all 0.3s ease-in-out;
                background: #fff;
            }
            span.color {
                width: 20px;
                height: 20px;
                border-radius: 100%;
                display: block;
                border: 1px solid rgba(245, 246, 247, 1);
                margin-right: 5px;
            }
            &::after {
                display: none;
            }
        }
        .btn-group {
            position: absolute;
            bottom: 10px;
            left: 1rem;
        }
        .dropdown-menu {
            width: 225px;
            padding: 10px;
            .dropdown-item {
                display: flex;
                /* background: rgb(245, 246, 247); */
                transition: all 0.3s ease-in-out;
                color: rgb(17, 17, 17);
                padding: 5px 10px;
                border-color: rgb(245, 246, 247);
                border-radius: 20px;
                position: relative;
                cursor: pointer;
                p {
                    margin: 0;
                }
                span.color {
                    width: 25px;
                    height: 25px;
                    border-radius: 100%;
                    display: block;
                    border: 1px solid rgba(245, 246, 247, 1);
                    margin-right: 10px;
                }
                &:first-child {
                    margin-top: 0;
                }
                &:last-child {
                    margin-bottom: 0;
                }
                &::after {
                    content: "";
                    border-bottom: 1px solid rgb(245, 246, 247);
                    width: calc(100% - 45px);
                    position: absolute;
                    bottom: 0;
                    left: 45px;
                }
            }
        }
    }
    .button-choice {
        min-width: 32px;
        max-width: 32px;
        min-height: 37px;
        max-height: 37px;
        position: relative;
        margin-right: 39px;
        .green {
            svg {
                fill: #3dc731;
            }
        }
        .icon {
            span {
                position: absolute;
                width: 100%;
                height: 100%;
                left: 0;
                text-align: center;
                line-height: 35px;
                color: #fff;
            }
        }
        #formFile {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            z-index: 9999;
        }
        &:last-child {
            margin-right: 0;
        }
    }
}
.showModal {
    display: none;
}
#padletModal {
    .modal-content {
        max-width: 600px;
        margin: 0 auto;
    }
    .btn-close {
        display: none;
        transition: all 0.3s ease-in-out;
        background: red;
        border-radius: 100%;
        position: absolute;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        color: #fff;
        transform: rotate(0);
        &:hover {
            transform: rotate(360deg);
        }
    }
}
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #f5f5f5;
}

::-webkit-scrollbar {
    width: 10px;
    background-color: #f5f5f5;
}
::-webkit-scrollbar-thumb {
    background-color: #fff;
    background-image: -webkit-linear-gradient(
        90deg,
        rgba(0, 0, 0, 1) 0%,
        rgba(0, 0, 0, 1) 25%,
        transparent 100%,
        rgba(0, 0, 0, 1) 75%,
        transparent
    );
}
.modal-body {
    scrollbar-color: rgba(0, 0, 0, 0.5) #fff;
    scrollbar-width: thin;
}
// .wrap-padlet {
//     padding-top: 83px;
// }
// .nav-main {
//     position: absolute !important;
// }
.pulse {
    animation: pulse 1s infinite ease-in-out alternate;
}
@keyframes pulse {
    from {
        transform: scale(0.8);
    }
    to {
        transform: scale(1.2);
    }
}
@media screen and (max-width: 1440px) {
    .masonry-sizer,
    .masonry-item {
        width: 19%;
    }
    .masonry {
        margin-left: 1%;
    }
    .gutter-sizer {
        width: 1%;
    }
}
@media screen and (max-width: 1168px) {
    .masonry-sizer,
    .masonry-item {
        width: 24%;
    }
}
@media screen and (max-width: 1168px) {
    .masonry-sizer,
    .masonry-item {
        width: 24%;
    }
}
@media screen and (max-width: 992px) {
    .masonry-sizer,
    .masonry-item {
        width: 32.3333333333333333333%;
    }
}
@media screen and (max-width: 568px) {
    .masonry-sizer,
    .masonry-item {
        width: 49%;
    }
}
@media screen and (max-width: 568px) {
    .masonry-sizer,
    .masonry-item {
        width: 100%;
    }
    .masonry {
        margin-left: 1%;
        margin-right: 1%;
    }
    .gutter-sizer {
        width: 0%;
    }
}
</style>
