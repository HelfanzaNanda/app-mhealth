class eiAPI{
  constructor(url,api_url){
    this.url=url;
    this.api_url=api_url;
    this.userdata=null;
    this.loadJwt();
    if(this.jwt){
      this.checkJwt();
    }
  }
  async checkJwt(){
    return await this.get('admin/check').then(response=>{
      if(response.data.status==0){
        // this.saveJwt("");
        // window.location.href=`${this.url}/login`;
        return false;
      }
      // console.log(response.data);
      // this.saveJwt(response.data.jwt)
      return true;
    }).catch(error=>{
      // this.saveJwt("");
      // return checkJwt();
      // return false;
    })

  }
  async post($url,$form){
    return axios.post(`${this.api_url}/${$url}`,$form,{
      headers:{
        'Authorization': 'Bearer ' + this.jwt
      }
    })
  }
  async get($url){
    return axios.get(`${this.api_url}/${$url}`,{
      headers:{
        'Authorization': 'Bearer ' + this.jwt
      }
    })
  }
  saveJwt(jwt){
    this.jwt=jwt;
    Cookies.set('jwt',this.jwt);
    Cookies.set('time',Date());

  }
  loadJwt(){
    // Cookies.remove('jwt');
    this.jwt = Cookies.get('jwt');
    console.log(Cookies.get('time'));
    // this.jwt = (this.jwt==undefined)?'':this.jwt;
    // alert(this.jwt);
  }
}