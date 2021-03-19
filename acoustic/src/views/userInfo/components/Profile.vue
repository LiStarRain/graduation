<template>
  <div id="profile">
    <b-form class="container" @submit="onSubmit" @reset="onReset" v-if="show">
      <div class="ml-2 mb-2 info-row">
        <div>
          <label for="update-username">
            <h4>用户名：</h4>
          </label>
        </div>
        <div>
          <h4 v-show="!editStatus">{{ form.username }}</h4>
          <b-form-group>
            <b-form-input :state="usernameStatus" @keyup="validateData('username',form.username)" v-show="editStatus"
              id="update-username" aria-describedby="input-live-feedback" v-model="form.username"></b-form-input>
            <b-form-invalid-feedback id="input-live-feedback">
              {{ usernameError }}
            </b-form-invalid-feedback>
          </b-form-group>
        </div>
      </div>

      <div class="ml-2 mb-2 info-row">
        <div>
          <h4>头像：</h4>
        </div>
        <div>
          <img v-show="!editStatus" :src="userInfo.head_img" alt="">
          <b-form-group v-show="editStatus" description="请选择你的头像">
            <b-form-file placeholder="请选择或拖入一张图片" v-model="form.head_img"></b-form-file>
          </b-form-group>
        </div>
      </div>

      <div class="ml-2 mb-2 info-row">
        <div>
          <label for="update-age">
            <h4>年龄：</h4>
          </label>
        </div>
        <div>
          <h4>{{ form.age }}</h4>
        </div>
      </div>

      <div class="ml-2 mb-2 info-row">
        <div>
          <label for="update-sex">
            <h4>性别：</h4>
          </label>
        </div>
        <div>
          <h4 v-show="!editStatus">{{ form.sex }}</h4>
          <b-form-group v-show="editStatus" v-slot="{ariaDescribedby}">
            <b-form-radio-group id="update-sex" v-model="form.sex" :options="options"
              :aria-describedby="ariaDescribedby"></b-form-radio-group>
          </b-form-group>
        </div>
      </div>

      <div class="ml-2 mb-2 info-row">
        <div class="flex-grow-2">
          <label for="update-birthday">
            <h4>生日：</h4>
          </label>
        </div>
        <div class="flex-grow-1">
          <h4 v-show="!editStatus">{{ form.birthday }}</h4>
          <b-form-group v-show="editStatus">
            <b-form-input @blur="getAge" @change="validateData('birthday',form.birthday)"
              aria-describedby="input-live-feedback" :state="birthdayStatus" id="update-birthday"
              v-model="form.birthday" type="date">
            </b-form-input>
            <b-form-invalid-feedback id="input-live-feedback">
              生日日期错误
            </b-form-invalid-feedback>
          </b-form-group>
        </div>
      </div>

      <div class="ml-2 mb-2 info-row">
        <div>
          <h4>注册日期：</h4>
        </div>
        <div>
          <h4>{{ userInfo.register_time }}</h4>
        </div>
      </div>

      <b-card class="mt-3" header="Form Data Result">
        <pre class="m-0">{{ form }}</pre>
      </b-card>

      <div class="btns" v-show="editStatus">
        <b-button v-show="editStatus" class="d-block col-12 mb-2" type="submit" variant="primary">保存</b-button>
        <b-button v-show="editStatus" class="d-block col-12 mb-2" type="reset" variant="danger">重置</b-button>
      </div>
      <div v-show="!editStatus" class="edit">
        <b-button @click="editProfile" class="d-block col-12 mb-2" type="button" variant="info">
          编辑个人资料
        </b-button>
      </div>
    </b-form>
  </div>
</template>

<script>
  // 引入验证类
  export default {
    name: 'Profile',
    props: ['userInfo'],
    data() {
      return {
        form: {
          username: '',
          head_img: null,
          age: '',
          sex: '',
          birthday: '',
        },
        show: true,
        // 用户名验证
        usernameStatus: true,
        usernameError: '用户名是由字母数字下划线组成的3～15位字符',
        // 年龄验证
        ageStatus: true,
        options: [{
            text: '男',
            value: '男'
          },
          {
            text: '女',
            value: '女'
          },
          {
            text: '保密',
            value: '保密'
          }
        ],
        // 生日验证
        birthdayStatus: true,
        // 是否编辑资料
        editStatus: false,
      }
    },
    methods: {
      // 表单验证
      validateData(type, data) {
        const status = this.$validate[type](data);
        status ? this[`${type}Status`] = true : this[`${type}Status`] = false;
      },

      onSubmit(e) {
        e.preventDefault();
        if (!(this.usernameStatus && this.ageStatus && this.birthdayStatus)) {
          return;
        }
        // 更新用户数据
        this.$User.updateUserInfo(this.form).then(res => {
          if (res.status == 200 && res.data) {
            this.$emit('editSuccess');
          }
        });
      },

      onReset(e) {
        e.preventDefault();
        this.form.username = this.userInfo['username'];
        this.usernameStatus = true;
        this.form.age = this.userInfo['age'];
        this.ageStatus = true;
        this.form.sex = this.userInfo['sex'];
        this.form.birthday = this.userInfo['birthday'];
        this.birthdayStatus = true;
        // 清除验证状态
        this.show = false
        this.$nextTick(() => {
          this.show = true
        });
      },

      // 编辑信息
      editProfile() {
        this.editStatus = true;
      },

      // 根据生日获取年龄
      getAge() {
        this.form.age = new Date(Date.now() - new Date(this.form.birthday) * 1).getFullYear() - 1970;
      }
    },
    created() {
      this.form.username = this.userInfo['username'];
      this.form.age = this.userInfo['age'];
      this.form.sex = this.userInfo['sex'];
      this.form.birthday = this.userInfo['birthday'];
    }
  }
</script>

<style lang="less" scoped>
  #profile {
    .container {
      .info-row {
        display: grid;
        grid-template-columns: 1fr 5fr;
        justify-content: start;
        align-items: center;

        @media screen and(max-width:768px) {
          grid-template-columns: 1fr 4fr;
        }

        @media screen and (max-width:600px) {
          grid-template-columns: 1fr 2fr;

          h4 {
            font-size: 1.2rem;
          }
        }
      }
    }

    img {
      width: 50px !important;
      height: 50px !important;
      border-radius: 50%;
    }
  }
</style>