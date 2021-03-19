<template>
  <section id="partners">
    <div class="show-partners">
      <h3 class="partner-intro">合作伙伴</h3>
      <div class="partner-images">
        <div class="partner-image" v-for="(partner,key) of partners" :key="key">
          <img :src="partner.src" alt="partner.name">
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  export default {
    name: 'Partners',
    data() {
      return {
        partners: [{
            name: 'YAcoustic',
            src: require('@/assets/images/partner1.png')
          },
          {
            name: 'YAcoustic',
            src: require('@/assets/images/partner1.png')
          },
          {
            name: 'YAcoustic',
            src: require('@/assets/images/partner1.png')
          },
          {
            name: 'YAcoustic',
            src: require('@/assets/images/partner1.png')
          },
          {
            name: 'YAcoustic',
            src: require('@/assets/images/partner1.png')
          },
          {
            name: 'YAcoustic',
            src: require('@/assets/images/partner1.png')
          }
        ]
      }
    },
  }
</script>

<style lang="less" scoped>
  @titleColor: #ea8f19;

  #partners {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 3rem 2rem;
    overflow: hidden;
    box-sizing: border-box;

    .show-partners {
      width: 700px;

      .partner-intro {
        font-size: 2rem;
        text-align: center;
        margin-bottom: 2rem;
        color: @titleColor;
        font-weight: bold;
      }

      .partner-images {
        width: 100%;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;

        .partner-image {
          width: 160px;
          border-radius: 50%;

          img {
            width: 100%;
            object-fit: cover;
            border-radius: 50%;
            transition: all .5s;

            &:hover {
              box-shadow: 0 0 5px 2px @titleColor;
            }
          }
        }
      }
    }

    @media screen and (max-width: 768px) {
      padding: 2rem 0 1rem 0;

      .show-partners {
        width: 100%;

        .partner-intro {
          font-size: 1.5em;
        }

        .partner-images {

          .partner-image {
            width: 120px;

            img {
              width: 100%;
            }
          }
        }
      }
    }
  }
</style>