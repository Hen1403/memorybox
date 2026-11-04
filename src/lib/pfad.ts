// Interne Adressen mit dem Basis-Ordner versehen.
// Auf der echten Domain ist der Basis-Ordner "/", in der GitHub-Pages-Vorschau "/memorybox/".
const basis = import.meta.env.BASE_URL.replace(/\/$/, '');

export function p(pfad: string) {
  return pfad.startsWith('/') ? `${basis}${pfad}` : pfad;
}
