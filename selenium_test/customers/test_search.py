from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import time

chrome_driver_path = r"C:\Users\nakabayashi-yugo\tools\chromedriver-win64\chromedriver.exe"

def test_search(data):
    service = Service(executable_path=chrome_driver_path)
    driver = webdriver.Chrome(service=service)
    login(driver)

    try:
        driver.get("http://localhost:3000/cust_list")

        # 検索項目に入力
        fill_search_form(driver, data)

        # 検索ボタンクリック
        driver.find_element(By.ID, "search-button").click()

        # テーブルに検索結果が反映されるまで最大10秒待つ
        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "list-customers-table")))

        time.sleep(3)

        assert_result(driver, data)

    finally:
        driver.quit()

def fill_search_form(driver, data):
    driver.find_element(By.NAME, "cust-name").send_keys(data.get("cust_name",""))
    driver.find_element(By.NAME, "cust-name-kana").send_keys(data.get("cust_name_kana",""))
    select = Select(driver.find_element(By.NAME, "sex"))
    print("▼ 性別選択肢:", [o.text for o in select.options])
    sex_text = data.get("sex", "")
    if sex_text:
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, f"//select[@name='sex']/option[text()='{sex_text}']"))
        )
        Select(driver.find_element(By.NAME, "sex")).select_by_visible_text(sex_text)
        
    driver.find_element(By.NAME, "born-year").send_keys(data.get("born_year",""))
    driver.find_element(By.NAME, "born-month").send_keys(data.get("born_month",""))
    driver.find_element(By.NAME, "born-date").send_keys(data.get("born_date",""))
    company_id = str(data.get("company_id", ""))

    # この行で、「指定した value の option が出てくるまで」最大10秒待つ！
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, f"//select[@name='company-id']/option[@value='{company_id}']"))
    )

    Select(driver.find_element(By.NAME, "company-id")).select_by_value(company_id)

def assert_result(driver, data):
    search_terms = [
        data.get("cust_name", ""),
        data.get("cust_name_kana", ""),
        data.get("sex", ""),
        data.get("born_year", ""),
        data.get("born_month", ""),
        data.get("born_date", "")
    ]

    company_id = data.get("company_id", "")
    if company_id:
        search_terms.append(company_id)

    # 入力が全くない場合は「全件表示されている」ことが成功判定
    if all(term == "" for term in search_terms):
        # テーブル内に何かデータ行が表示されているか確認
        rows = driver.find_elements(By.CSS_SELECTOR, "#list-customers-table tbody tr")
        assert len(rows) > 0, "全件表示されるはずなのにデータがありません"
        return

    # 入力値のいずれかが検索結果に含まれていれば成功
    found = any(term in driver.page_source for term in search_terms if term)
    if not found:
        assert "該当するデータはありません" in driver.page_source


def login(driver):
    driver.get("http://localhost:3000/user_login")
    driver.find_element(By.NAME, "user-name").send_keys("nakabayashi")
    driver.find_element(By.NAME, "password").send_keys("nakabayashi2025")
    driver.find_element(By.XPATH, "//button[text()='ログイン']").click()
    WebDriverWait(driver, 5).until(EC.alert_is_present())
    driver.switch_to.alert.accept()

if __name__ == "__main__":
    test_data_list = [
        {
            "cust_name": "", 
            "cust_name_kana": "", 
            "sex": "", 
            "born_year": "", 
            "born_month": "", 
            "born_date": "", 
            "company_id": ""
        },
        {
            "cust_name": "六", 
            "cust_name_kana": "", 
            "sex": "", 
            "born_year": "", 
            "born_month": "", 
            "born_date": "", 
            "company_id": ""
        },
        {
            "cust_name": "", 
            "cust_name_kana": "テストタロウ", 
            "sex": "", 
            "born_year": "", 
            "born_month": "", 
            "born_date": "", 
            "company_id": ""
        },
        {
            "cust_name": "", 
            "cust_name_kana": "", 
            "sex": "男性", 
            "born_year": "", 
            "born_month": "", 
            "born_date": "", 
            "company_id": ""
        },
        {
            "cust_name": "", 
            "cust_name_kana": "", 
            "sex": "", 
            "born_year": "1998", 
            "born_month": "", 
            "born_date": "", 
            "company_id": ""
        },
        {
            "cust_name": "", 
            "cust_name_kana": "", 
            "sex": "", 
            "born_year": "", 
            "born_month": "5", 
            "born_date": "", 
            "company_id": ""
        },
        {
            "cust_name": "", 
            "cust_name_kana": "", 
            "sex": "", 
            "born_year": "", 
            "born_month": "", 
            "born_date": "25", 
            "company_id": ""
        },
        {
            "cust_name": "", 
            "cust_name_kana": "", 
            "sex": "", 
            "born_year": "", 
            "born_month": "", 
            "born_date": "", 
            "company_id": "23"
        },
        {
            "cust_name": "六之助", 
            "cust_name_kana": "ロクノスケジャナイ", 
            "sex": "", 
            "born_year": "", 
            "born_month": "", 
            "born_date": "", 
            "company_id": ""
        },
        {
            "cust_name": "", 
            "cust_name_kana": "テスト", 
            "sex": "その他", 
            "born_year": "", 
            "born_month": "", 
            "born_date": "", 
            "company_id": ""
        },
        {
            "cust_name": "", 
            "cust_name_kana": "", 
            "sex": "", 
            "born_year": "2020", 
            "born_month": "2", 
            "born_date": "30", 
            "company_id": ""
        },
    ]

    for i, data in enumerate(test_data_list):
        print(f"\n▶ テストケース {i+1} 開始")
        test_search(data)
