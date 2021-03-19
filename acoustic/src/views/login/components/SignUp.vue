<template>
  <div>
    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
      <b-form-group id="input-group-1" label="电子邮箱：" label-for="email" description="我们不会泄漏您的个人邮箱">
        <b-form-input :state="emailStatus" @keyup="validateData('email',form.email)"
          aria-describedby="input-live-feedback" id="email" v-model="form.email" type="email" placeholder="请输入邮箱地址"
          required>
        </b-form-input>
        <b-form-invalid-feedback id="input-live-feedback">
          {{ emailError }}
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group id="input-group-2" label="用户名：" label-for="username">
        <b-form-input @keyup="validateData('username',form.username)" :state="usernameStatus" maxLength=15
          aria-describedby="input-live-feedback" id="username" v-model="form.username" placeholder="请输入用户名" required>
        </b-form-input>
        <b-form-invalid-feedback id="input-live-feedback">
          {{ usernameError }}
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group id="input-group-3" label="密码:" label-for="password">
        <b-form-input :state="passwordStatus" @keyup="validateData('password',form.password)"
          aria-describedby="input-live-feedback" id="password" type="password" placeholder="请输入密码"
          v-model="form.password" required></b-form-input>
        <b-form-invalid-feedback id="input-live-feedback">
          密码至少有8位
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group :state="confirmStatus" id="input-group-4" label="确认密码：" label-for="confirm">
        <b-form-input :state="confirmStatus" @keyup="confirmPassword" aria-describedby="input-live-feedback"
          id="confirm" type="password" placeholder="请再次输入密码" v-model="pwdConfirm" required>
        </b-form-input>
        <b-form-invalid-feedback id="input-live-feedback">
          两次密码输入不一致
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="性别：" v-slot="{ ariaDescribedby }">
        <b-form-radio-group required id="radio-group-1" v-model="form.sex" :options="options"
          :aria-describedby="ariaDescribedby" name="radio-options"></b-form-radio-group>
      </b-form-group>

      <b-form-group label="生日：" label-for="birthday">
        <b-form-input @blur="getAge" @change="validateData('birthday',form.birthday)"
          aria-describedby="input-live-feedback" :state="birthdayStatus" id="birthday" required v-model="form.birthday"
          type="date">
        </b-form-input>
        <b-form-invalid-feedback id="input-live-feedback">
          生日日期错误
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="选择一张头像（非必须）：" label-for="head_img">
        <b-form-file accept="image/gif,image/jpeg,image/png" v-model="form.head_img" placeholder="选择或拖拽一张图片到这儿"
          drop-placeholder="拖拽文件到这儿..."></b-form-file>
        <div class="mt-3">选择的文件：{{ form.head_img ? form.head_img.name : '' }}</div>
      </b-form-group>

      <b-form-group id="captcha" label="验证码：" label-for="input-3" description="看不清？点击图片刷新验证码">
        <b-form-input :state="captchaStatus" aria-describedby="input-live-feedback" id="captcha" maxLength=4
          v-model="form.captcha" placeholder="请输入验证码" required>
        </b-form-input>
        <img class="img-responsive mt-3 rounded" :src="captcha" @click='updateCaptcha' alt="captcha">
        <b-form-invalid-feedback id="input-live-feedback">
          验证码错误，请刷新验证码后再试
        </b-form-invalid-feedback>
      </b-form-group>

      <b-button type="submit" class="d-block col-12 mb-3" variant="primary">注册</b-button>
      <b-button type="reset" class="d-block col-12" variant="danger">重置</b-button>
    </b-form>
    <b-card class="mt-3" header="Form Data Result">
      <pre class="m-0">{{ form }}</pre>
    </b-card>

    <!-- 注册成功的模态框 -->
    <register-success></register-success>
  </div>
</template>

<script>
  import RegisterSuccess from './RegisterSuccess.vue';

  export default {
    name: 'SignUp',
    components: {
      RegisterSuccess
    },
    data() {
      return {
        form: {
          email: '',
          username: '',
          password: '',
          sex: '男',
          birthday: '',
          captcha: '',
          head_img: null,
          age: ''
        },
        captcha: '/api/Captcha',
        show: true,
        pwdConfirm: '',
        // 单选框
        options: [{
          text: '男',
          value: '男'
        }, {
          text: '女',
          value: '女'
        }, {
          text: '保密',
          value: '保密'
        }],
        // 邮箱验证
        emailStatus: null,
        emailError: '请输正确的邮箱格式',
        // 用户名验证
        usernameStatus: null,
        usernameError: '用户名是由字母数字下划线组成的3～15位字符',
        // 密码验证
        passwordStatus: null,
        confirmStatus: null,
        // 生日验证
        formatted: '',
        birthdayStatus: null,
        // 验证码验证
        captchaStatus: null
      }
    },
    methods: {
      validateData(type, data) {
        const status = this.$validate[type](data);
        status ? this[`${type}Status`] = true : this[`${type}Status`] = false;
      },

      getAge() {
        // 根据生日计算出年龄
        this.form.age = new Date(Date.now() - new Date(this.form.birthday) * 1).getFullYear() - 1970;
      },

      confirmPassword() {
        const status = this.pwdConfirm === this.form.password;
        this.confirmStatus = status ? true : false;
      },

      onSubmit(event) {
        event.preventDefault();
        if (!(this.emailStatus && this.usernameStatus && this.passwordStatus && this.confirmStatus &&
            this.birthdayStatus)) {
          return;
        }
        this.$User.register(this.form).then(res => {
          if (res.data === '验证码不匹配') {
            this.captchaStatus = false;
          } else if (res.data === '邮箱被占用') {
            this.emailStatus = false;
            this.emailError = '邮箱被占用';
          } else if (res.data === '用户名被占用') {
            this.usernameStatus = false;
            this.usernameError = '用户名被占用';
          } else {
            // 注册成功
            this.$bvModal.show('bv-modal-register-success');
            // 跳转到登录页面
            setTimeout(() => {
              this.$router.go(0);
            }, 3000);
          }
        }).catch(e => {
          console.log(e.message);
        });
      },

      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form.email = '';
        this.emailStatus = null;
        this.form.username = '';
        this.usernameStatus = null;
        this.form.password = '';
        this.passwordStatus = null;
        this.pwdConfirm = '';
        this.confirmStatus = null;
        this.form.sex = '';
        this.form.birthday = '';
        this.birthdayStatus = null;
        this.form.age = '';
        this.ageStatus = null;
        this.updateCaptcha();
        this.form.head_img = null;
        this.form.captchaCode = '';
        // 清除浏览器的验证状态
        this.show = false
        this.$nextTick(() => {
          this.show = true
        });
      },

      onContext(ctx) {
        this.formatted = '日期格式错误';
        this.form.birthday = ctx.selectedYMD;
      },
      updateCaptcha() {
        this.captcha = `/api/Captcha?${Math.random() * 10}`;
      }
    }
  }
</script>