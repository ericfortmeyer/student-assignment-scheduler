export function obj2Uint8Array(obj: any): Uint8Array {
    return new TextEncoder().encode(JSON.stringify(obj));
}
