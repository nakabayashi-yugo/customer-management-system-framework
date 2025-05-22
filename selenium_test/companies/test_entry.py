from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import time

chrome_driver_path = r"C:\Users\nakabayashi-yugo\tools\chromedriver-win64\chromedriver.exe"

def test_entry(data):
    service = Service(executable_path=chrome_driver_path)
    driver = webdriver.Chrome(service=service)
    login(driver)

    try:
        driver.get("http://localhost:3000/cust_entry")

        # 会社一覧ボタン押す(モーダル画面を出す)
        driver.find_element(By.XPATH, "//button[text()='会社一覧']").click()

        # モーダル画面が出るまで待つ
        WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.XPATH, "//button[text()='会社登録']"))
        )

        # 会社登録モーダル画面表示
        driver.find_element(By.XPATH, "//button[text()='会社登録']").click()

        # 会社登録モーダル画面が出るまで待つ
        WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.NAME, "company-name"))
        )

        # 入力する
        fill_user_form(driver, data)

        # 「登録」ボタン押す
        modal = driver.find_element(By.CLASS_NAME, "modal-company-entry")
        modal.find_element(By.XPATH, ".//button[text()='登録']").click()

        # ✅ アラートが出るまで最大10秒待つ
        WebDriverWait(driver, 10).until(EC.alert_is_present())

        time.sleep(1)
        # ✅ アラート処理
        try:
            alert = driver.switch_to.alert
            print("アラート内容:", alert.text)
            alert.accept()
        except:
            print("⚠️ アラートが見つかりませんでした")

        time.sleep(1)

        # 成功後の画面の文言確認（必要に応じて変更）
        assert "所属会社登録" in driver.page_source

    finally:
        driver.quit()

def fill_user_form(driver, data):
    driver.find_element(By.NAME, "company-name").send_keys(data.get("company_name",""))

def login(driver):
    driver.get("http://localhost:3000/user_login")
    driver.find_element(By.NAME, "user-name").send_keys("nakabayashi")
    driver.find_element(By.NAME, "password").send_keys("nakabayashi2025")
    driver.find_element(By.XPATH, "//button[text()='ログイン']").click()
    WebDriverWait(driver, 5).until(EC.alert_is_present())
    driver.switch_to.alert.accept()

if __name__ == "__main__":
    test_data_list = [
        {"company_name": ""},
        {"company_name": "株式会社ワニワニパニック科所属胴体部分専門製造製品取扱説明書発行現場専用弁当配達部門"},
        {"company_name": "株式会社ワニワニパニック"},
    ]

    for i, data in enumerate(test_data_list):
        print(f"\n▶ テストケース {i+1} 開始")
        test_entry(data)
