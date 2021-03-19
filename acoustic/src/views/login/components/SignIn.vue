<template>
  <div id="signIn">
    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
      <b-form-group id="input-group-1" label="电子邮箱：" label-for="email" description="我们不会泄漏您的邮箱信息">
        <b-form-input :state="emailStatus" @keyup="validateData('email',form.email)"
          aria-describedby="input-live-feedback" trim id="email" v-model="form.email" type="email"
          placeholder="输入您的电子邮箱" required>
        </b-form-input>
        <b-form-invalid-feedback id="input-live-feedback">
          请输正确的邮箱格式
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group id="input-group-2" label="密码：" label-for="password">
        <b-form-input id="password" type="password" v-model="form.password" placeholder="请输入密码" required></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="验证码：" label-for="captcha" description="看不清？点击图片刷新验证码">
        <b-form-input :state="captchaStatus" aria-describedby="input-live-feedback" maxLength=4 id="captcha"
          v-model="form.captchaCode" placeholder="请输入验证码" required>
        </b-form-input>
        <img :state="captchaStatus" class="img-responsive mt-3 rounded" :src="captcha" @click='updateCaptcha'
          alt="captcha">
        <b-form-invalid-feedback id="input-live-feedback">
          验证码错误，请刷新验证码后再试
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group>
        <b-button class="d-block col-lg-12 mb-3" type="submit" variant="primary">登录</b-button>
        <b-button class="d-block col-lg-12" type="reset" variant="danger">重置</b-button>
      </b-form-group>
    </b-form>
    <b-card class="mt-3" header="Form Data Result">
      <pre class="m-0">{{ form }}</pre>
    </b-card>

    <!-- 登录失败的模态框 -->
    <login-failed></login-failed>
  </div>
</template>

<script>
  import LoginFailed from './LoginFailed.vue';

  export default {
    name: 'SignIn',
    components: {
      LoginFailed
    },
    data() {
      return {
        form: {
          email: '',
          password: '',
          captchaCode: '',
        },
        captcha: '/api/Captcha',
        show: true,
        // 邮箱验证状态
        emailStatus: null,
        // 验证码验证状态
        captchaStatus: null
      }
    },
    methods: {
      // 表单数据验证
      validateData(type, data) {
        const status = this.$validate[type](data);
        status ? this[`${type}Status`] = true : this[`${type}Status`] = false;
      },
      onSubmit(event) {
        event.preventDefault()
        this.$User.login(this.form.email, this.form.password, this.form.captchaCode).then(
          res => {
            if (res.data == true) {
              this.$router.push('/');
              this.$router.go(0);
            } else if (res.data === '验证码不匹配') {
              this.captchaStatus = false;
            } else {
              this.$bvModal.show('bv-modal-login-failed');
            }
          }
        ).catch(e => {
          console.log(e.message);
        });
      },
      onReset(event) {
        event.preventDefault()
        // 重置表单
        this.form.email = '';
        this.form.password = '';
        this.form.captcha = '';
        this.emailStatus = null;
        this.captchaStatus = null;
        this.updateCaptcha();
        // 更新DOM
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
      updateCaptcha() {
        this.captcha = `/api/Captcha?${Math.random() * 10}`;
      }
    }
  }
</script>