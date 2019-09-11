import { Injectable } from '@angular/core';
import { base64ToArrayBuffer } from './conversion/functions/base64ToArrayBuffer';
import { obj2Uint8Array } from "./conversion/functions/obj2Uint8Array";
import { arrayBuffer2Base64 } from "./conversion/functions/arrayBuffer2Base64";
import { base64ToObj } from "./conversion/functions/base64ToObj";
import { OauthToken } from 'src/app/oauth-token';
import { OauthTokenSignature } from 'src/app/oauth-token-signature';
import { unpreparedJWT } from './unpreparedJWT';
import { preparedJWT } from './preparedJWT';
import { deserializedJWT } from './deserializedJWT';
import { SecretKeyProvider } from './secret-key-provider';

@Injectable({
    providedIn: 'root'
})

/*
A utility for handling token related tasks.

https://tools.ietf.org/html/rfc7519
https://jose.readthedocs.io/en/latest/#jwk-format
http://tools.ietf.org/html/draft-ietf-oauth-jwt-bearer

Signing the token is done to verify the source.
The tokens have a short lifetime so forgery isn't feasible.
Precautions should be put in place to safely store the secret key.
Optionally, logging users in can be done in a separate app.
*/
export class TokenHandler {
    private readonly signingAlgorithm = 'HMAC';
    private readonly JWTDelimiter = '.';
    constructor(private secretKeyProvider: SecretKeyProvider){}
    async sign(token: OauthToken): Promise<ArrayBuffer> {
        const jsonStringEncoded = obj2Uint8Array(token);
        const alg = this.signingAlgorithm;
        const key = await this.secretKeyProvider.getKey();
        return crypto.subtle.sign(alg, key, jsonStringEncoded);
    }
    async verify({ signatureB64, data, signingAlgorithm  }: { signatureB64: string; data: OauthToken; signingAlgorithm?: string; }): Promise<Boolean> {
        const alg = signingAlgorithm || this.signingAlgorithm;
        const key = await this.secretKeyProvider.getKey();
        return crypto.subtle.verify(alg, key, base64ToArrayBuffer(signatureB64), obj2Uint8Array(data));
    }
    deserialize(jwt: string): deserializedJWT {
        let [header, token, signature] = jwt.split(this.JWTDelimiter);
        return {
            header: base64ToObj(header),
            token: base64ToObj(token),
            signature: base64ToArrayBuffer(signature)
        } as deserializedJWT;
    }
    serializeAndStore(storageKey: string, JWT: unpreparedJWT, signature: OauthTokenSignature): void {
        const preparedJWT: preparedJWT = this.prepareForSerialization(JWT, signature);
        const jwt: string = this.serialize(preparedJWT);
        localStorage.setItem(storageKey, jwt);
    }
    private serialize(preparedJWT: preparedJWT): string {
        return Object.values(preparedJWT)
            .map(val => arrayBuffer2Base64(val))
            .join(this.JWTDelimiter);
    }
    private prepareForSerialization(JWT: unpreparedJWT, signature: OauthTokenSignature): preparedJWT {
        return {
            header: obj2Uint8Array(JWT.header),
            token: obj2Uint8Array(JWT.token),
            signature: signature
        } as preparedJWT;
    }
}
