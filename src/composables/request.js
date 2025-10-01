import axios from "axios";

export function request(verb, uri, params = {}, useToken = true, partialLink= true) {
  let authorization = { headers: {} };

  if (useToken) {
    authorization = {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("zyzy")}`
      },
    };
  }

  var link= ""

  if(partialLink){
    link= process.env.VUE_APP_BASE_URI + uri
  }else{
    link= uri
  }

  if (verb.toLowerCase() === "post") {
    return axios.post(link, params, authorization);
  } else if (verb.toLowerCase() === "get") {
    return axios.get(link, { ...authorization, params });
  } else if (verb.toLowerCase() === "put") {
    return axios.put(link, params, authorization);
  } else if (verb.toLowerCase() === "delete") {
    return axios.delete(link, { ...authorization, data: params });
  } else {
    throw new Error(`Método HTTP não suportado: ${verb}`);
  }
}