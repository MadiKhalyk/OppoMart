import{T as c,h as g,c as p,o as r,w as i,a as o,b as n,f as y,g as v,u as t,Z as b,d as x,n as h,e as a,j as k}from"./app-0m9RpkNe.js";import{_}from"./GuestLayout-D9DjByFh.js";import{P as w}from"./PrimaryButton-kXJ19KRw.js";import"./ApplicationLogo-VVGqx6K6.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const V={key:0,class:"mb-4 font-medium text-sm text-green-600"},B={class:"mt-4 flex items-center justify-between"},T={__name:"VerifyEmail",props:{status:{type:String}},setup(d){const l=d,s=c({}),u=()=>{s.post(route("verification.send"))},m=g(()=>l.status==="verification-link-sent");return(f,e)=>(r(),p(_,null,{default:i(()=>[o(t(b),{title:"Email Verification"}),e[2]||(e[2]=n("div",{class:"mb-4 text-sm text-gray-600"}," Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another. ",-1)),m.value?(r(),y("div",V," A new verification link has been sent to the email address you provided during registration. ")):v("",!0),n("form",{onSubmit:x(u,["prevent"])},[n("div",B,[o(w,{class:h({"opacity-25":t(s).processing}),disabled:t(s).processing},{default:i(()=>e[0]||(e[0]=[a(" Resend Verification Email ")])),_:1},8,["class","disabled"]),o(t(k),{href:f.route("logout"),method:"post",as:"button",class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:i(()=>e[1]||(e[1]=[a("Log Out")])),_:1},8,["href"])])],32)]),_:1}))}};export{T as default};
