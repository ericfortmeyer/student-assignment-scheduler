import { OauthTokenTimestamp } from './oauth-token-timestamp';

export class OauthTokenHeader {
    type?: string;
    alg: string;
    exp: OauthTokenTimestamp;
}
