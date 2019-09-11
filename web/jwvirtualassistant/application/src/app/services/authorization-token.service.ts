import { Injectable } from '@angular/core';
import { OauthToken } from '../oauth-token';
import { MaybeOauthToken } from '../maybe-oauth-token';
import { OauthTokenTimestamp } from '../oauth-token-timestamp';
import { OauthTokenSignature } from '../oauth-token-signature';
import { OauthTokenHeader } from '../oauth-token-header';
import { TokenHandler } from 'src/lib/token-handler';
import { base64ToObj } from "src/lib/conversion/functions/base64ToObj";
import { unpreparedJWT } from 'src/lib/unpreparedJWT';

@Injectable({
  providedIn: 'root'
})

export class AuthorizationTokenService {
  private readonly JWTDelimiter: string = '.';
  private readonly tokenLifetime: number = 3600;
  private readonly tokenHeaderAlgo: string = 'HS512';
  private readonly localStorageTokenKey: string = 'jwva_t';
  private jwt: string;
  constructor(private tokenHandler: TokenHandler) {}
  async getToken(): Promise<MaybeOauthToken> {
    let [ /* header is not used */, tokenB64, signatureB64]: string[] = this.jwt.split(this.JWTDelimiter);
    const token = base64ToObj(tokenB64);
    const isValid: Boolean = await this.tokenHandler.verify(
      {
        signatureB64: signatureB64,
        data: token
      }
    );
    return { isValid: isValid, ...token } as MaybeOauthToken;
  }
  isTokenStale(): boolean {
    const currentTimestamp = Date.now() / 1000;
    return this.getExpirationTimestamp() <= currentTimestamp;
  }
  storeToken(token: OauthToken): void {
    this.tokenHandler.sign(token).then(
      (signature: OauthTokenSignature) => {
        const unpreparedJWT = {
          header: { alg: this.tokenHeaderAlgo, exp: Date.now() / 1000 + this.tokenLifetime } as OauthTokenHeader,
          token: token
        } as unpreparedJWT;
        this.tokenHandler.serializeAndStore(this.localStorageTokenKey, unpreparedJWT, signature);
      }
    );
  }
  private getExpirationTimestamp(): OauthTokenTimestamp {
    let [headerB64] = this.jwt.split(this.JWTDelimiter);
    const header = base64ToObj(headerB64);
    return header.exp as OauthTokenTimestamp;
  }
}
