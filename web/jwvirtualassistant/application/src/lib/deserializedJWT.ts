import { OauthTokenSignature } from 'src/app/oauth-token-signature';
import { OauthTokenHeader } from 'src/app/oauth-token-header';
import { OauthToken } from 'src/app/oauth-token';

export class deserializedJWT {
    header: OauthTokenHeader;
    token: OauthToken;
    signature: OauthTokenSignature;
}
