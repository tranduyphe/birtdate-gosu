<script>
import WOW from "wow.js";
import "animate.css";
import $ from "jQuery";
import Masonry from "masonry-layout";
import imagesLoaded from "imagesloaded";
import "remixicon/fonts/remixicon.css";
import { socketMethods, walltMethods, wallGetters } from "@/store/store";
import { socket } from "@/store/socket";
import Header from '@/components/layouts/Header';
import { Helper } from "@/helper";
export default {
    components: {
        name: "MasonryLayout",
        Header
    },
    data: () => {
        return {
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
            images: null,
            dataUser: {},
            hidden: false,
            expand: false,
            disabled: false,
            infoUsers: false,
            currentPadlets: false,
            checkMessenger: false,
        };
    },
    computed: {
        ...wallGetters,
    },
    methods: {
        ...socketMethods,
        ...walltMethods,
        initializeMasonry() {
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
        async handleCreate() {
            const resultData = await this.createWall(this.data);
            if (resultData) {
                this.handleShowForm();
                this.items.push(resultData);
                this.sendData(resultData);
            }
        },
        handleRemoveFile() {
            this.images = null;
            this.data.file = null;
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
            ){
                this.disabled = false;
                let checkTextTitle = Helper.checkRibaldry(this.data.title);
                let checkTextContent = Helper.checkRibaldry(this.data.content);
                if (checkTextContent | checkTextTitle) {
                    this.disabled = true;
                    this.checkMessenger = true
                }else{
                    this.checkMessenger = false
                }

            }else{ this.disabled = true; this.checkMessenger = false}
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
            if (results) {
                this.sendUpdateData(results);
            }
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
            this.$refs.padletModal.click();
        },
    },
    watch: { },
    updated() {
        if(!this.hidden)
        this.initializeMasonry();
        this.handleDisabledForm();        
        const $this = this;
        $(document).ready(function () {
            $('.nav-main').remove();
            $('body').addClass('overflow-hidden');
            $("#dropColor .dropdown-item").on("click", function () {
                var $color = $(this).find(".color").attr("data-color");
                var $name = $(this).find(".color").attr("data-name");
                $this.data.color = $color ? $color : '255,255,255';
                $("#dropContent").find(".name").text($name);
                $("#dropContent")
                    .find(".color")
                    .css("background-color", "rgb(" + $color + ")");
            });
        });
    },
    created() {
        // this.initializeMasonry();
    },
    async mounted() {
        // var body = document.getElementsByTagName('body');
        // body.classList.setAttribute("class", "overflow-hidden");
        const $this = this;
        this.dataUser = JSON.parse(localStorage.getItem("users") || "{}");
        this.connect();
        if (Object.keys(this.dataUser).length > 0) {
            const dataRoom = {
                room: "padlet",
                profile_id: this.dataUser.profile_id,
            };
            this.joinRoom(dataRoom);
        }
        this.items = await this.indexWall();
        
        // get data from server
        socket.on("listen data", function (data) {
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
        });
        const wow = new WOW({
            boxClass: "wow",
            animateClass: "animated",
            offset: 0,
            live: true,
        });
        wow.init();
    },
};
</script>
<template>
    <perfect-scrollbar>
        <div class="wrap-padlet">
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
                        :class="['masonry-item wow fadeInUp pb-2 px-2 pt-2']"
                        v-bind:style="`background-color:rgb(${item.color && item.color != 'null' ? item.color : '255,255,255'})`"
                    >
                        <div class="wrap-content">
                            <div
                                class="content-wall pb-2"
                                @click="handleShowModal(item.id)"
                            >
                                <h5 v-if="item.title && item.title != 'null'">{{ item.title }}</h5>
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
                                        item.liked && item.liked != 0 ? item.liked : ""
                                    }}</small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    :class="['wrap-model w-100', `${expand ? 'show' : ''}`]"
                    v-if="hidden"
                >
                    <span class="close" @click="handleShowForm"></span>
                    <form class="wrapper-form" action="" @submit.prevent="handleCreate">
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
                                <!-- <li class="nav-item">
                                    <span class="btn btn-light">
                                        <i class="ri-subtract-line"></i>
                                    </span>
                                </li> -->
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
                                    <!-- <div class="button-upload button-choice">
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
                                        />
                                    </div> -->
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
                                    <!-- <div class="button-upload button-choice">
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
                                        />
                                    </div> -->
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
                            <span class="error-message" v-if="checkMessenger">Vui lòng không sử dụng từ ngữ tục tĩu</span>
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
                            <ul class="dropdown-menu" id="dropColor">
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
                <div class="addPadlet" @click="handleShowForm">
                    <span class=""><i class="ri-add-line"></i></span>
                </div>
            </div>
        </div>
    </perfect-scrollbar>
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
                v-bind:style="`background-color:rgb${currentPadlets.color && currentPadlets.color != 'null' ? currentPadlets.color : '255,255,255'}})`"
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
                            <h5 v-if="currentPadlets.title  && currentPadlets.title != 'null'">
                                {{ currentPadlets.title }}
                            </h5>
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
                        </div>
                    </div>
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
        &:hover {
            i {
                color: red;
            }
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
.addPadlet {
    position: fixed;
    right: 10px;
    bottom: 10px;
    z-index: 9;
    width: 50px;
    height: 50px;
    border-radius: 100%;
    background: rgb(200, 71, 53);
    transition: all 0.3s ease-in-out;
    transform: rotate(360deg);
    text-align: center;
    line-height: 50px;
    cursor: pointer;
    i {
        transform: rotate(0deg);
        transition: all 0.3s ease-in-out;
        font-size: 20px;
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
</style>
