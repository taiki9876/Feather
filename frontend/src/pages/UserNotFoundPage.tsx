import React from "react";

type Props = {
  requestedId: number;
}
export const UserNotFoundPage = ({requestedId,}: Props) => {
  return <>ユーザーが見つかりません{requestedId}</>;
};
