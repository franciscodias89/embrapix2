!function(){"use strict";const t=[];for(let e=0;e<256;e++){let n=e;for(let t=0;t<8;t++)1&n?n=n>>>1^3988292384:n>>>=1;t[e]=n}class e{constructor(t){this.crc=t||-1}append(e){let n=0|this.crc;for(let s=0,r=0|e.length;s<r;s++)n=n>>>8^t[255&(n^e[s])];this.crc=n}get(){return~this.crc}}const n={concat(t,e){if(0===t.length||0===e.length)return t.concat(e);const s=t[t.length-1],r=n.getPartial(s);return 32===r?t.concat(e):n._shiftRight(e,r,0|s,t.slice(0,t.length-1))},bitLength(t){const e=t.length;if(0===e)return 0;const s=t[e-1];return 32*(e-1)+n.getPartial(s)},clamp(t,e){if(32*t.length<e)return t;const s=(t=t.slice(0,Math.ceil(e/32))).length;return e&=31,s>0&&e&&(t[s-1]=n.partial(e,t[s-1]&2147483648>>e-1,1)),t},partial:(t,e,n)=>32===t?e:(n?0|e:e<<32-t)+1099511627776*t,getPartial:t=>Math.round(t/1099511627776)||32,_shiftRight(t,e,s,r){for(void 0===r&&(r=[]);e>=32;e-=32)r.push(s),s=0;if(0===e)return r.concat(t);for(let n=0;n<t.length;n++)r.push(s|t[n]>>>e),s=t[n]<<32-e;const a=t.length?t[t.length-1]:0,i=n.getPartial(a);return r.push(n.partial(e+i&31,e+i>32?s:r.pop(),1)),r}},s={bytes:{fromBits(t){const e=n.bitLength(t)/8,s=new Uint8Array(e);let r;for(let n=0;n<e;n++)0==(3&n)&&(r=t[n/4]),s[n]=r>>>24,r<<=8;return s},toBits(t){const e=[];let s,r=0;for(s=0;s<t.length;s++)r=r<<8|t[s],3==(3&s)&&(e.push(r),r=0);return 3&s&&e.push(n.partial(8*(3&s),r)),e}}},r={sha1:function(t){t?(this._h=t._h.slice(0),this._buffer=t._buffer.slice(0),this._length=t._length):this.reset()}};r.sha1.prototype={blockSize:512,reset:function(){const t=this;return t._h=this._init.slice(0),t._buffer=[],t._length=0,t},update:function(t){const e=this;"string"==typeof t&&(t=s.utf8String.toBits(t));const r=e._buffer=n.concat(e._buffer,t),a=e._length,i=e._length=a+n.bitLength(t);if(i>9007199254740991)throw new Error("Cannot hash more than 2^53 - 1 bits");const c=new Uint32Array(r);let o=0;for(let t=e.blockSize+a-(e.blockSize+a&e.blockSize-1);t<=i;t+=e.blockSize)e._block(c.subarray(16*o,16*(o+1))),o+=1;return r.splice(0,16*o),e},finalize:function(){const t=this;let e=t._buffer;const s=t._h;e=n.concat(e,[n.partial(1,1)]);for(let t=e.length+2;15&t;t++)e.push(0);for(e.push(Math.floor(t._length/4294967296)),e.push(0|t._length);e.length;)t._block(e.splice(0,16));return t.reset(),s},_init:[1732584193,4023233417,2562383102,271733878,3285377520],_key:[1518500249,1859775393,2400959708,3395469782],_f:function(t,e,n,s){return t<=19?e&n|~e&s:t<=39?e^n^s:t<=59?e&n|e&s|n&s:t<=79?e^n^s:void 0},_S:function(t,e){return e<<t|e>>>32-t},_block:function(t){const e=this,n=e._h,s=Array(80);for(let e=0;e<16;e++)s[e]=t[e];let r=n[0],a=n[1],i=n[2],c=n[3],o=n[4];for(let t=0;t<=79;t++){t>=16&&(s[t]=e._S(1,s[t-3]^s[t-8]^s[t-14]^s[t-16]));const n=e._S(5,r)+e._f(t,a,i,c)+o+s[t]+e._key[Math.floor(t/20)]|0;o=c,c=i,i=e._S(30,a),a=r,r=n}n[0]=n[0]+r|0,n[1]=n[1]+a|0,n[2]=n[2]+i|0,n[3]=n[3]+c|0,n[4]=n[4]+o|0}};const a={aes:class{constructor(t){const e=this;e._tables=[[[],[],[],[],[]],[[],[],[],[],[]]],e._tables[0][0][0]||e._precompute();const n=e._tables[0][4],s=e._tables[1],r=t.length;let a,i,c,o=1;if(4!==r&&6!==r&&8!==r)throw new Error("invalid aes key size");for(e._key=[i=t.slice(0),c=[]],a=r;a<4*r+28;a++){let t=i[a-1];(a%r==0||8===r&&a%r==4)&&(t=n[t>>>24]<<24^n[t>>16&255]<<16^n[t>>8&255]<<8^n[255&t],a%r==0&&(t=t<<8^t>>>24^o<<24,o=o<<1^283*(o>>7))),i[a]=i[a-r]^t}for(let t=0;a;t++,a--){const e=i[3&t?a:a-4];c[t]=a<=4||t<4?e:s[0][n[e>>>24]]^s[1][n[e>>16&255]]^s[2][n[e>>8&255]]^s[3][n[255&e]]}}encrypt(t){return this._crypt(t,0)}decrypt(t){return this._crypt(t,1)}_precompute(){const t=this._tables[0],e=this._tables[1],n=t[4],s=e[4],r=[],a=[];let i,c,o,l;for(let t=0;t<256;t++)a[(r[t]=t<<1^283*(t>>7))^t]=t;for(let h=i=0;!n[h];h^=c||1,i=a[i]||1){let a=i^i<<1^i<<2^i<<3^i<<4;a=a>>8^255&a^99,n[h]=a,s[a]=h,l=r[o=r[c=r[h]]];let p=16843009*l^65537*o^257*c^16843008*h,d=257*r[a]^16843008*a;for(let n=0;n<4;n++)t[n][h]=d=d<<24^d>>>8,e[n][a]=p=p<<24^p>>>8}for(let n=0;n<5;n++)t[n]=t[n].slice(0),e[n]=e[n].slice(0)}_crypt(t,e){if(4!==t.length)throw new Error("invalid aes block size");const n=this._key[e],s=n.length/4-2,r=[0,0,0,0],a=this._tables[e],i=a[0],c=a[1],o=a[2],l=a[3],h=a[4];let p,d,u,f=t[0]^n[0],g=t[e?3:1]^n[1],y=t[2]^n[2],w=t[e?1:3]^n[3],_=4;for(let t=0;t<s;t++)p=i[f>>>24]^c[g>>16&255]^o[y>>8&255]^l[255&w]^n[_],d=i[g>>>24]^c[y>>16&255]^o[w>>8&255]^l[255&f]^n[_+1],u=i[y>>>24]^c[w>>16&255]^o[f>>8&255]^l[255&g]^n[_+2],w=i[w>>>24]^c[f>>16&255]^o[g>>8&255]^l[255&y]^n[_+3],_+=4,f=p,g=d,y=u;for(let t=0;t<4;t++)r[e?3&-t:t]=h[f>>>24]<<24^h[g>>16&255]<<16^h[y>>8&255]<<8^h[255&w]^n[_++],p=f,f=g,g=y,y=w,w=p;return r}}},i={ctrGladman:class{constructor(t,e){this._prf=t,this._initIv=e,this._iv=e}reset(){this._iv=this._initIv}update(t){return this.calculate(this._prf,t,this._iv)}incWord(t){if(255==(t>>24&255)){let e=t>>16&255,n=t>>8&255,s=255&t;255===e?(e=0,255===n?(n=0,255===s?s=0:++s):++n):++e,t=0,t+=e<<16,t+=n<<8,t+=s}else t+=1<<24;return t}incCounter(t){0===(t[0]=this.incWord(t[0]))&&(t[1]=this.incWord(t[1]))}calculate(t,e,s){let r;if(!(r=e.length))return[];const a=n.bitLength(e);for(let n=0;n<r;n+=4){this.incCounter(s);const r=t.encrypt(s);e[n]^=r[0],e[n+1]^=r[1],e[n+2]^=r[2],e[n+3]^=r[3]}return n.clamp(e,a)}}},c={hmacSha1:class{constructor(t){const e=this,n=e._hash=r.sha1,s=[[],[]],a=n.prototype.blockSize/32;e._baseHash=[new n,new n],t.length>a&&(t=n.hash(t));for(let e=0;e<a;e++)s[0][e]=909522486^t[e],s[1][e]=1549556828^t[e];e._baseHash[0].update(s[0]),e._baseHash[1].update(s[1]),e._resultHash=new n(e._baseHash[0])}reset(){const t=this;t._resultHash=new t._hash(t._baseHash[0]),t._updated=!1}update(t){this._updated=!0,this._resultHash.update(t)}digest(){const t=this,e=t._resultHash.finalize(),n=new t._hash(t._baseHash[1]).update(e).finalize();return t.reset(),n}}},o="Invalid pasword",l=16,h={name:"PBKDF2"},p=Object.assign({hash:{name:"HMAC"}},h),d=Object.assign({iterations:1e3,hash:{name:"SHA-1"}},h),u=["deriveBits"],f=[8,12,16],g=[16,24,32],y=10,w=[0,0,0,0],_=crypto.subtle,b=s.bytes,m=a.aes,k=i.ctrGladman,A=c.hmacSha1;class U{constructor(t,e,n){Object.assign(this,{password:t,signed:e,strength:n-1,pendingInput:new Uint8Array(0)})}async append(t){const e=this;if(e.password){const n=B(t,0,f[e.strength]+2);await async function(t,e,n){await C(t,n,B(e,0,f[t.strength]));const s=B(e,f[t.strength]),r=t.keys.passwordVerification;if(r[0]!=s[0]||r[1]!=s[1])throw new Error(o)}(e,n,e.password),e.password=null,e.aesCtrGladman=new k(new m(e.keys.key),Array.from(w)),e.hmac=new A(e.keys.authentication),t=B(t,f[e.strength]+2)}return v(e,t,new Uint8Array(t.length-y-(t.length-y)%l),0,y,!0)}async flush(){const t=this,e=t.pendingInput,n=B(e,0,e.length-y),s=B(e,e.length-y);let r=new Uint8Array(0);if(n.length){const e=b.toBits(n);t.hmac.update(e);const s=t.aesCtrGladman.update(e);r=b.fromBits(s)}let a=!0;if(t.signed){const e=B(b.fromBits(t.hmac.digest()),0,y);for(let t=0;t<y;t++)e[t]!=s[t]&&(a=!1)}return{valid:a,data:r}}}class z{constructor(t,e){Object.assign(this,{password:t,strength:e-1,pendingInput:new Uint8Array(0)})}async append(t){const e=this;let n=new Uint8Array(0);e.password&&(n=await async function(t,e){const n=crypto.getRandomValues(new Uint8Array(f[t.strength]));return await C(t,e,n),S(n,t.keys.passwordVerification)}(e,e.password),e.password=null,e.aesCtrGladman=new k(new m(e.keys.key),Array.from(w)),e.hmac=new A(e.keys.authentication));const s=new Uint8Array(n.length+t.length-t.length%l);return s.set(n,0),v(e,t,s,n.length,0)}async flush(){const t=this;let e=new Uint8Array(0);if(t.pendingInput.length){const n=t.aesCtrGladman.update(b.toBits(t.pendingInput));t.hmac.update(n),e=b.fromBits(n)}const n=B(b.fromBits(t.hmac.digest()),0,y);return{data:S(e,n),signature:n}}}function v(t,e,n,s,r,a){const i=e.length-r;let c;for(t.pendingInput.length&&(e=S(t.pendingInput,e),n=function(t,e){if(e&&e>t.length){const n=t;(t=new Uint8Array(e)).set(n,0)}return t}(n,i-i%l)),c=0;c<=i-l;c+=l){const r=b.toBits(B(e,c,c+l));a&&t.hmac.update(r);const i=t.aesCtrGladman.update(r);a||t.hmac.update(i),n.set(b.fromBits(i),c+s)}return t.pendingInput=B(e,c),n}async function C(t,e,n){const s=(new TextEncoder).encode(e),r=await _.importKey("raw",s,p,!1,u),a=await _.deriveBits(Object.assign({salt:n},d),r,8*(2*g[t.strength]+2)),i=new Uint8Array(a);t.keys={key:b.toBits(B(i,0,g[t.strength])),authentication:b.toBits(B(i,g[t.strength],2*g[t.strength])),passwordVerification:B(i,2*g[t.strength])}}function S(t,e){let n=t;return t.length+e.length&&(n=new Uint8Array(t.length+e.length),n.set(t,0),n.set(e,t.length)),n}function B(t,e,n){return t.subarray(e,n)}const I=12;class D{constructor(t,e){Object.assign(this,{password:t,passwordVerification:e}),j(this,t)}async append(t){const e=this;if(e.password){const n=V(e,t.subarray(0,I));if(e.password=null,n[11]!=e.passwordVerification)throw new Error(o);t=t.subarray(I)}return V(e,t)}async flush(){return{valid:!0,data:new Uint8Array(0)}}}class H{constructor(t,e){Object.assign(this,{password:t,passwordVerification:e}),j(this,t)}async append(t){const e=this;let n,s;if(e.password){e.password=null;const r=crypto.getRandomValues(new Uint8Array(I));r[11]=e.passwordVerification,n=new Uint8Array(t.length+r.length),n.set(M(e,r),0),s=I}else n=new Uint8Array(t.length),s=0;return n.set(M(e,t),s),n}async flush(){return{data:new Uint8Array(0)}}}function V(t,e){const n=new Uint8Array(e.length);for(let s=0;s<e.length;s++)n[s]=E(t)^e[s],O(t,n[s]);return n}function M(t,e){const n=new Uint8Array(e.length);for(let s=0;s<e.length;s++)n[s]=E(t)^e[s],O(t,e[s]);return n}function j(t,n){t.keys=[305419896,591751049,878082192],t.crcKey0=new e(t.keys[0]),t.crcKey2=new e(t.keys[2]);for(let e=0;e<n.length;e++)O(t,n.charCodeAt(e))}function O(t,e){t.crcKey0.append([e]),t.keys[0]=~t.crcKey0.get(),t.keys[1]=G(t.keys[1]+K(t.keys[0])),t.keys[1]=G(Math.imul(t.keys[1],134775813)+1),t.crcKey2.append([t.keys[1]>>>24]),t.keys[2]=~t.crcKey2.get()}function E(t){const e=2|t.keys[2];return K(Math.imul(e,1^e)>>>8)}function K(t){return 255&t}function G(t){return 4294967295&t}const W="deflate",L="inflate",P="Invalid signature";class T{constructor(t,{signature:n,password:s,signed:r,compressed:a,zipCrypto:i,passwordVerification:c,encryptionStrength:o},{chunkSize:l}){const h=Boolean(s);Object.assign(this,{signature:n,encrypted:h,signed:r,compressed:a,inflate:a&&new t({chunkSize:l}),crc32:r&&new e,zipCrypto:i,decrypt:h&&i?new D(s,c):new U(s,r,o)})}async append(t){const e=this;return e.encrypted&&t.length&&(t=await e.decrypt.append(t)),e.compressed&&t.length&&(t=await e.inflate.append(t)),(!e.encrypted||e.zipCrypto)&&e.signed&&t.length&&e.crc32.append(t),t}async flush(){const t=this;let e,n=new Uint8Array(0);if(t.encrypted){const e=await t.decrypt.flush();if(!e.valid)throw new Error(P);n=e.data}if((!t.encrypted||t.zipCrypto)&&t.signed){const n=new DataView(new Uint8Array(4).buffer);if(e=t.crc32.get(),n.setUint32(0,e),t.cipher!=n.getUint32(0,!1))throw new Error(P)}return t.compressed&&(n=await t.inflate.append(n)||new Uint8Array(0),await t.inflate.flush()),{data:n,signature:e}}}class R{constructor(t,{encrypted:n,signed:s,compressed:r,level:a,zipCrypto:i,password:c,passwordVerification:o,encryptionStrength:l},{chunkSize:h}){Object.assign(this,{encrypted:n,signed:s,compressed:r,deflate:r&&new t({level:a||5,chunkSize:h}),crc32:s&&new e,zipCrypto:i,encrypt:n&&i?new H(c,o):new z(c,l)})}async append(t){const e=this;let n=t;return e.compressed&&t.length&&(n=await e.deflate.append(t)),e.encrypted&&n.length&&(n=await e.encrypt.append(n)),(!e.encrypted||e.zipCrypto)&&e.signed&&t.length&&e.crc32.append(t),n}async flush(){const t=this;let e,n=new Uint8Array(0);if(t.compressed&&(n=await t.deflate.flush()||new Uint8Array(0)),t.encrypted){n=await t.encrypt.append(n);const s=await t.encrypt.flush();e=s.signature;const r=new Uint8Array(n.length+s.data.length);r.set(n,0),r.set(s.data,n.length),n=r}return t.encrypted&&!t.zipCrypto||!t.signed||(e=t.crc32.get()),{data:n,signature:e}}}const x={init(t){t.scripts&&t.scripts.length&&importScripts.apply(void 0,t.scripts);const e=t.options;let n;self.initCodec&&self.initCodec(),e.codecType.startsWith(W)?n=self.Deflate:e.codecType.startsWith(L)&&(n=self.Inflate),F=function(t,e,n){return e.codecType.startsWith(W)?new R(t,e,n):e.codecType.startsWith(L)?new T(t,e,n):void 0}(n,e,t.config)},append:async t=>({data:await F.append(t.data)}),flush:()=>F.flush()};let F;addEventListener("message",(async t=>{const e=t.data,n=e.type,s=x[n];if(s)try{e.data&&(e.data=new Uint8Array(e.data));const t=await s(e)||{};if(t.type=n,t.data)try{t.data=t.data.buffer,postMessage(t,[t.data])}catch(e){postMessage(t)}else postMessage(t)}catch(t){postMessage({type:n,error:{message:t.message,stack:t.stack}})}}));function q(t,e,n){return class{constructor(s){const r=this;r.codec=new t(Object.assign({},e,s)),n(r.codec,(t=>{if(r.pendingData){const e=r.pendingData;r.pendingData=new Uint8Array(e.length+t.length),r.pendingData.set(e,0),r.pendingData.set(t,e.length)}else r.pendingData=new Uint8Array(t)}))}async append(t){return this.codec.push(t),s(this)}async flush(){return this.codec.push(new Uint8Array(0),!0),s(this)}};function s(t){if(t.pendingData){const e=t.pendingData;return t.pendingData=null,e}return new Uint8Array(0)}}self.initCodec=()=>{const{Deflate:t,Inflate:e}=((t,e={},n)=>({Deflate:q(t.Deflate,e.deflate,n),Inflate:q(t.Inflate,e.inflate,n)}))(fflate,void 0,((t,e)=>t.ondata=e));self.Deflate=t,self.Inflate=e}}();
