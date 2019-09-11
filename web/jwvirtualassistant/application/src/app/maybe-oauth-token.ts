import { OauthToken } from './oauth-token';
import { OauthTokenInvalid } from './oauth-token-invalid';

export type MaybeOauthToken = OauthToken | OauthTokenInvalid;
