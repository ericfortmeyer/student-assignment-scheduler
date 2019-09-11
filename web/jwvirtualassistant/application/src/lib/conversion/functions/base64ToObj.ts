import { base64ToArrayBuffer } from './base64ToArrayBuffer';
import { arrayBuffer2PlainText } from "./arrayBuffer2PlainText";
export function base64ToObj(base64String: string): any {
    return JSON.parse(arrayBuffer2PlainText(base64ToArrayBuffer(base64String)));
}
