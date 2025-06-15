import React from "react";

type Props = {
  title: string;
  description: string;
}
export const WelcomePage = ({title, description}: Props) => {
  return <div>
    <h1>Welcome Page</h1>
    <p>{title}</p>
    <p>{description}</p>
  </div>
};
