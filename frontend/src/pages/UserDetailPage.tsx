import React from "react";
import {User} from "../types";

export type Props = {
  user: User;
}
export const UserDetailPage = ({ user }: Props) => {
  return (
    <div className="user-detail-container">
      <div className="user-detail-card">
        <h1 className="user-detail-title">ユーザー詳細</h1>

        <div className="user-profile">
          <div className="profile-header">
            <h2 className="user-name">{user.displayName}</h2>
            <span
              className={`user-category ${user.isAdult ? "adult" : "minor"}`}
            >
              {user.ageCategory}
            </span>
          </div>

          <div className="profile-details">
            <div className="detail-row">
              <span className="detail-label">ID:</span>
              <span className="detail-value">{user.id}</span>
            </div>

            <div className="detail-row">
              <span className="detail-label">メールアドレス:</span>
              <span className="detail-value">{user.email}</span>
            </div>

            <div className="detail-row">
              <span className="detail-label">年齢:</span>
              <span className="detail-value">{user.age}歳</span>
            </div>

            <div className="detail-row">
              <span className="detail-label">登録日:</span>
              <span className="detail-value">{user.formattedCreatedAt}</span>
            </div>
          </div>
        </div>

        <div className="user-actions">
          <a href="/users" className="btn btn-primary">
            ユーザー一覧に戻る
          </a>
          <a href="/" className="btn btn-secondary">
            ホーム
          </a>
        </div>
      </div>

      <style
        dangerouslySetInnerHTML={{
          __html: `
        .user-detail-container {
          display: flex;
          justify-content: center;
          align-items: center;
          min-height: 100vh;
          padding: 1rem;
        }

        .user-detail-card {
          max-width: 600px;
          width: 100%;
          background: white;
          border-radius: 8px;
          box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          padding: 2rem;
        }

        .user-detail-title {
          font-size: 2rem;
          font-weight: bold;
          margin: 0 0 1.5rem 0;
          color: #333;
        }

        .user-profile {
          background-color: #f8f9fa;
          padding: 1.5rem;
          border-radius: 8px;
          margin: 1.5rem 0;
        }

        .profile-header {
          display: flex;
          align-items: center;
          gap: 1rem;
          margin-bottom: 1rem;
          flex-wrap: wrap;
        }

        .user-name {
          margin: 0;
          font-size: 1.5rem;
          color: #333;
        }

        .user-category {
          padding: 0.3rem 0.8rem;
          border-radius: 20px;
          font-size: 0.9rem;
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

        .profile-details {
          border-top: 1px solid #dee2e6;
          padding-top: 1rem;
        }

        .detail-row {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 0.5rem 0;
          border-bottom: 1px solid #e9ecef;
        }

        .detail-row:last-child {
          border-bottom: none;
        }

        .detail-label {
          font-weight: bold;
          color: #666;
          min-width: 120px;
        }

        .detail-value {
          color: #333;
          text-align: right;
        }

        .user-actions {
          margin-top: 1.5rem;
          display: flex;
          gap: 0.5rem;
          flex-wrap: wrap;
        }

        .btn {
          display: inline-block;
          padding: 0.5rem 1rem;
          border-radius: 4px;
          text-decoration: none;
          font-weight: 500;
          transition: background-color 0.2s ease;
        }

        .btn-primary {
          background-color: #007bff;
          color: white;
        }

        .btn-primary:hover {
          background-color: #0056b3;
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
