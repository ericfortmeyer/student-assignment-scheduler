import { OauthTokenSignature } from 'src/app/oauth-token-signature';

export class preparedJWT {
    header: Uint8Array;
    token: Uint8Array;
    signature: OauthTokenSignature;
}
