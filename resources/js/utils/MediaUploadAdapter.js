export default class MediaUploadAdapter {
  constructor(loader) {
      this.loader = loader;
  }

  upload() {
      return this.loader.file.then(uploadedFile => {
          return new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('image', uploadedFile);
            axios.post(
              '/api/images',
              formData,
            ).then(response => {
              if (response.status === 201) {
                  resolve({default: response.data.path});
              } else {
                  reject(response.data.message);
              }
            }).catch(error => {
              // console.log(error.response.headers);
              console.log(error.response.status, error.response.data.message);
            });
          });
      });
  }

  abort() {
  }
}