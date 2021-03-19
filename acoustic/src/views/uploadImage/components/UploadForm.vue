<template>
  <div id="upload-form">
    <b-form v-if="show" @submit="onSubmit" @reset="onReset">
      <b-form-group id="select-file" label="请选择图片：" lable-for="input-file" description="请选择你要上传的图片，支持批量上传">
        <b-form-file aria-describedby="input-live-feedback" accept="image/*" multiple id="input-file"
          v-model="form.files" :state="fileStatus" required placeholder="请选择或拖入需要上传的图片" drop-placeholder="请把图片拖到这里">
        </b-form-file>
        <b-form-invalid-feedback id="input-live-feedback">
          文件大小超过限制
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group v-slot="{ariaDescribedby}" id="select-tag" label="请选择图片的分类：" description="请选择您上传图片的所属分类">
        <b-form-checkbox-group id="input-tag" :aria-describedby="ariaDescribedby" :options="tags" v-model="form.tag">
        </b-form-checkbox-group>
      </b-form-group>

      <b-form-group label="请输入图片的描述：" label-for="input-desc" description="请用简短的词语概括您所上传的图片内容">
        <b-form-input placeholder="输入图片的描述" id="input-desc" v-model="form.desc"></b-form-input>
      </b-form-group>

      <b-button class="d-block col-12 mb-3" type="submit" variant="primary">上传</b-button>
      <b-button class="d-block col-12" type="reset" variant="danger">重置</b-button>
    </b-form>

    <b-card class="mt-3" header="Form data result">
      <pre class="m-0">{{ form }}</pre>
    </b-card>
  </div>
</template>

<script>
  import Glance from '../../../assets/js/Glance/Glance.js'

  export default {
    name: 'UploadForm',
    data() {
      return {
        form: {
          files: [],
          tag: ['all'],
          desc: ''
        },
        tags: [{
            text: '乐器',
            value: 'guitar'
          },
          {
            text: '艺术家',
            value: 'artist'
          },
          {
            text: '现场演出',
            value: 'live'
          },
          {
            text: '艺术照',
            value: 'photos'
          },
          {
            text: '其他',
            value: 'all'
          }
        ],
        show: true,
        fileStatus: null,
      }
    },
    methods: {
      onSubmit(event) {
        event.preventDefault();
        let filesSize = this.form.files.reduce((total, file) => {
          return total += file.size;
        }, 0);
        filesSize = Math.ceil(filesSize / (1024 * 1024));
        if (filesSize >= 500) {
          this.fileStatus = true;
          return;
        }
        // 开始上传
        this.$emit('uploading');
        Glance.uploadImages(this.form).then(res => {
          if (res.status === 200 && res.data === 1) {
            // 上传成功
            this.$emit('uploadSuccess');
          } else {
            // 上传失败
            this.$emit('uploadFailed');
          }
        }).catch(e => {
          // 上传失败
          this.$emit('uploadFailed');
        });
      },
      onReset(event) {
        event.preventDefault();
        // 重置数据
        this.form.files = [];
        this.form.tag = ['all'];
        this.form.desc = '';
        // 清除浏览器的默认验证状态
        this.show = false;
        this.$nextTick(() => {
          this.show = true;
        });
      }
    },
  }
</script>