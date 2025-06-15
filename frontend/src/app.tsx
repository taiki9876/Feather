import { reactView } from "./reactView";
import { WelcomePage } from "./pages/WelcomePage";
import { UserListPage } from "./pages/UserListPage";
import { UserDetailPage } from "./pages/UserDetailPage";
import { UserNotFoundPage } from "./pages/UserNotFoundPage";

// コンポーネントを登録
reactView.registerComponents({
  Welcome: WelcomePage,
  "Users/Index": UserListPage,
  "Users/Show": UserDetailPage,
  "Users/NotFound": UserNotFoundPage,
});

// DOMContentLoadedで初期化
document.addEventListener("DOMContentLoaded", async () => {
  const app = document.getElementById("app");
  if (!app) {
    console.error("App container not found");
    return;
  }

  // 初期ページデータを取得
  const initialPageData = app.getAttribute("data-page");
  if (!initialPageData) {
    console.error("Initial page data not found");
    return;
  }

  try {
    const initialPage = JSON.parse(initialPageData);
    await reactView.init(app, initialPage);
    console.log("Inertia initialized successfully");
  } catch (error) {
    console.error("Failed to initialize Inertia:", error);
  }
});
