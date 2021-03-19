<template>
  <div id="upload-form">
    <b-form v-if="show" @submit="onSubmit" @reset="onReset">
      <b-form-group id="select-video" label="请选择视频：" lable-for="input-video" description="请选择你要上传的视频，目前只支持mp4格式的文件">
        <b-form-file aria-describedby="input-live-feedback" required accept="video/mp4" id="input-video"
          v-model="form.video" :state="fileStatus" placeholder="请选择或拖入需要上传的视频" drop-placeholder="请把视频拖到这里">
        </b-form-file>
        <b-form-invalid-feedback id="input-live-feedback">
          文件大小超过限制
        </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group id="select-file" label="请选择视频封面：" lable-for="input-file" description="请选择你要上传的视频封面">
        <b-form-file accept="image/*" id="input-file" v-model="form.poster" :state="Boolean(form.poster)" required
          placeholder="请选择或拖入需要上传的视频封面" drop-placeholder="请把图片拖到这里"></b-form-file>
      </b-form-group>

      <b-form-group v-slot="{ariaDescribedby}" id="select-tag" label="请选择图片的分类：" description="请选择您上传图片的所属分类">
        <b-form-checkbox-group id="input-tag" :aria-describedby="ariaDescribedby" :options="tags" v-model="form.tag">
        </b-form-checkbox-group>
      </b-form-group>

      <b-form-group label="请输入视频的描述：" label-for="input-desc" description="请用简短的词语概括您所上传的视频内容">
        <b-form-input placeholder="输入视频的描述" id="input-desc" v-model="form.desc"></b-form-input>
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
  import Video from '../../../assets/js/Video/Video.js'

  export default {
    name: 'UploadForm',
    data() {
      return {
        form: {
          poster: null,
          video: null,
          tag: ['all'],
          desc: ''
        },
        tags: [{
            text: '演奏视频',
            value: 'playing'
          },
          {
            text: '现场演出',
            value: 'live'
          },

          {
            text: '音乐知识',
            value: 'knowledge'
          },
          {
            text: '其他',
            value: 'all'
          }
        ],
        show: true,
        // 文件大小限制
        fileStatus: null
      }
    },
    methods: {
      onSubmit(event) {
        event.preventDefault();
        let fileSize = this.form.video.size + this.form.poster.size;
        fileSize = Math.ceil(fileSize / (1024 * 1024));
        if (fileSize > 500) {
          this.fileStatus = true;
          return;
        }
        // 开始上传
        this.$emit('uploading');
        Video.uploadVideos(this.form).then(res => {
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
        this.form.poster = null;
        this.form.video = null;
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