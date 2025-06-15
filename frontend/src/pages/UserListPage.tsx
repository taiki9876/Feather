import React from "react";
import {User, UserListMeta} from "../types";

export type Props = {
    users: User[];
    meta: UserListMeta;
}
export const UserListPage = ({ users, meta }: Props) => {
  return (
    <div className="user-list-container">
      <div className="user-list-card">
        <h1 className="user-list-title">ユーザー一覧</h1>

        <div className="user-meta">
          <p className="meta-text">
            全 {meta.total} 名のユーザー （成人: {meta.adultCount}
            名、未成年: {meta.minorCount}名）
          </p>
        </div>

        <div className="user-list">
          {users.map((user) => (
            <div key={user.id} className="user-card">
              <div>
                <h3 className="user-name">
                  <a href={`/users/${user.id}`} className="user-link">
                    {user.displayName}
                  </a>
                </h3>
                <div className="user-details">
                  <span className="user-email">{user.email}</span>
                  <span className="user-age">{user.age}歳</span>
                  <span
                    className={`user-category ${
                      user.isAdult ? "adult" : "minor"
                    }`}
                  >
                    {user.ageCategory}
                  </span>
                </div>
                <p className="user-created">
                  登録日: {user.formattedCreatedAt}
                </p>
              </div>
            </div>
          ))}
        </div>

        <div className="user-actions">
          <a href="/" className="btn btn-secondary">
            ホームに戻る
          </a>
        </div>
      </div>

      <style
        dangerouslySetInnerHTML={{
          __html: `
        .user-list-container {
          display: flex;
          justify-content: center;
          align-items: center;
          min-height: 100vh;
          padding: 1rem;
        }

        .user-list-card {
          max-width: 800px;
          width: 100%;
          background: white;
          border-radius: 8px;
          box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          padding: 2rem;
        }

        .user-list-title {
          font-size: 2rem;
          font-weight: bold;
          margin: 0 0 1rem 0;
          color: #333;
        }

        .user-meta {
          margin: 1rem 0;
        }

        .meta-text {
          color: #666;
          font-size: 0.9rem;
        }

        .user-list {
          margin: 1.5rem 0;
        }

        .user-card {
          background: #f8f9fa;
          border-radius: 6px;
          padding: 1rem;
          margin-bottom: 1rem;
          border-left: 4px solid #007bff;
          transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .user-card:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .user-name {
          margin: 0 0 0.5rem 0;
          font-size: 1.2rem;
        }

        .user-link {
          color: #007bff;
          text-decoration: none;
          font-weight: 500;
        }

        .user-link:hover {
          text-decoration: underline;
        }

        .user-details {
          margin: 0.5rem 0;
          display: flex;
          flex-wrap: wrap;
          gap: 1rem;
          align-items: center;
        }

        .user-email {
          color: #666;
        }

        .user-age {
          font-weight: bold;
          color: #333;
        }

        .user-category {
          padding: 0.2rem 0.5rem;
          border-radius: 4px;
          font-size: 0.8rem;
          font-weight: bold;
        }

        .user-category.adult {
          background-color: #d4edda;
          color: #155724;
        }

        .user-category.minor {
          background-color: #fff3cd;
          color: #856404;
        }

        .user-created {
          margin: 0.5rem 0 0 0;
          font-size: 0.85rem;
          color: #888;
        }

        .user-actions {
          margin-top: 1.5rem;
        }

        .btn {
          display: inline-block;
          padding: 0.5rem 1rem;
          border-radius: 4px;
          text-decoration: none;
          font-weight: 500;
          transition: background-color 0.2s ease;
        }

        .btn-secondary {
          background-color: #6c757d;
          color: white;
        }

        .btn-secondary:hover {
          background-color: #5a6268;
        }
      `,
        }}
      />
    </div>
  );
};
