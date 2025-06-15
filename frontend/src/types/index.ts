export interface User {
  id: number;
  name: string;
  email: string;
  age: number;
  isAdult: boolean;
  createdAt: string;
  formattedCreatedAt: string;
  displayName: string;
  ageCategory: string;
}

export interface UserListMeta {
  total: number;
  adultCount: number;
  minorCount: number;
}
